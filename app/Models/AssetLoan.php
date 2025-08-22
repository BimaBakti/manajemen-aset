<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetLoan extends Model
{
    /** @use HasFactory<\Database\Factories\AssetLoanFactory> */
    use HasFactory;

    protected $fillable = [
        'loan_number',
        'asset_id',
        'borrowed_by',
        'approved_by',
        'purpose',
        'requested_from',
        'requested_until',
        'actual_return_date',
        'status',
        'approval_notes',
        'return_notes',
        'condition_on_loan',
        'condition_on_return',
    ];

    protected function casts(): array
    {
        return [
            'requested_from' => 'date',
            'requested_until' => 'date',
            'actual_return_date' => 'date',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (AssetLoan $loan) {
            if (empty($loan->loan_number)) {
                $loan->loan_number = static::generateLoanNumber();
            }
        });
    }

    public static function generateLoanNumber(): string
    {
        $prefix = 'AL';
        $year = now()->format('Y');
        $lastLoan = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $lastLoan ? ((int) substr($lastLoan->loan_number, -4)) + 1 : 1;
        
        return $prefix . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function borrowedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'borrowed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || 
               ($this->status === 'active' && $this->requested_until < now()->toDateString());
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'blue',
            'active' => 'green',
            'returned' => 'gray',
            'overdue' => 'red',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    public function getDaysRemainingAttribute(): int
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return now()->diffInDays($this->requested_until, false);
    }
}

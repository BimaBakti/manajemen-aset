<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcurementRequest extends Model
{
    /** @use HasFactory<\Database\Factories\ProcurementRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'request_number',
        'requested_by',
        'department_id',
        'title',
        'description',
        'justification',
        'estimated_budget',
        'needed_by',
        'priority',
        'status',
        'approved_by',
        'approved_at',
        'approval_notes',
        'vendor_id',
        'actual_cost',
        'order_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'needed_by' => 'date',
            'approved_at' => 'datetime',
            'order_date' => 'date',
            'estimated_budget' => 'decimal:2',
            'actual_cost' => 'decimal:2',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ProcurementRequest $request) {
            if (empty($request->request_number)) {
                $request->request_number = static::generateRequestNumber();
            }
        });
    }

    public static function generateRequestNumber(): string
    {
        $prefix = 'PR';
        $year = now()->format('Y');
        $lastRequest = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $lastRequest ? ((int) substr($lastRequest->request_number, -4)) + 1 : 1;
        
        return $prefix . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['draft', 'submitted', 'under_review']);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'submitted' => 'blue',
            'under_review' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'gray',
            'medium' => 'blue',
            'high' => 'yellow',
            'urgent' => 'red',
            default => 'gray',
        };
    }
}

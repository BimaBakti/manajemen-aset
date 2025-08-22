<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetRequest extends Model
{
    /** @use HasFactory<\Database\Factories\AssetRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'request_number',
        'requested_by',
        'department_id',
        'asset_id',
        'category_id',
        'asset_type',
        'description',
        'justification',
        'needed_by',
        'priority',
        'status',
        'approved_by',
        'approved_at',
        'approval_notes',
        'assigned_asset_id',
        'assigned_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'needed_by' => 'date',
            'approved_at' => 'datetime',
            'assigned_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (AssetRequest $request) {
            if (empty($request->request_number)) {
                $request->request_number = static::generateRequestNumber();
            }
        });
    }

    public static function generateRequestNumber(): string
    {
        $prefix = 'AR';
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

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedAsset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'assigned_asset_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
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
            'assigned' => 'green',
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

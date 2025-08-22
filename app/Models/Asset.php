<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Asset extends Model
{
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    use HasFactory;

    protected $fillable = [
        'asset_tag',
        'name',
        'description',
        'category_id',
        'location_id',
        'serial_number',
        'model',
        'brand',
        'purchase_price',
        'purchase_date',
        'warranty_expiry',
        'status',
        'condition',
        'notes',
        'qr_code',
        'specifications',
        'assigned_to',
        'assigned_at',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'warranty_expiry' => 'date',
            'assigned_at' => 'date',
            'specifications' => 'array',
            'purchase_price' => 'decimal:2',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Asset $asset) {
            if (empty($asset->asset_tag)) {
                $asset->asset_tag = static::generateAssetTag();
            }
        });
    }

    public static function generateAssetTag(): string
    {
        $prefix = 'AST';
        $year = now()->format('Y');
        $lastAsset = static::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
        
        $number = $lastAsset ? ((int) substr($lastAsset->asset_tag, -4)) + 1 : 1;
        
        return $prefix . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(AssetLoan::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(AssetRequest::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isInUse(): bool
    {
        return $this->status === 'in_use';
    }

    public function isInMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    public function isRetired(): bool
    {
        return $this->status === 'retired';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'green',
            'in_use' => 'blue',
            'maintenance' => 'yellow',
            'retired' => 'gray',
            'lost' => 'red',
            default => 'gray',
        };
    }

    public function getConditionColorAttribute(): string
    {
        return match($this->condition) {
            'excellent' => 'green',
            'good' => 'blue',
            'fair' => 'yellow',
            'poor' => 'red',
            default => 'gray',
        };
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        'employee_id',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedAssets(): HasMany
    {
        return $this->hasMany(Asset::class, 'assigned_to');
    }

    public function assetLoans(): HasMany
    {
        return $this->hasMany(AssetLoan::class, 'borrowed_by');
    }

    public function assetRequests(): HasMany
    {
        return $this->hasMany(AssetRequest::class, 'requested_by');
    }

    public function procurementRequests(): HasMany
    {
        return $this->hasMany(ProcurementRequest::class, 'requested_by');
    }

    public function approvedProcurementRequests(): HasMany
    {
        return $this->hasMany(ProcurementRequest::class, 'approved_by');
    }

    public function approvedAssetRequests(): HasMany
    {
        return $this->hasMany(AssetRequest::class, 'approved_by');
    }

    public function approvedAssetLoans(): HasMany
    {
        return $this->hasMany(AssetLoan::class, 'approved_by');
    }

    public function managedDepartments(): HasMany
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProcurement(): bool
    {
        return $this->role === 'procurement';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}

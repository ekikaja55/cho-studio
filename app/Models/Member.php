<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     * We explicitly set this to 'members' to match your application's design.
     * @var string
     */
    protected $table = 'members';

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'member_id';

    /**
     * The attributes that are mass assignable.
     * This allows us to use Member::create() in the registration controller.
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'line_id',
        'phone_number',
        'instagram',
        'role', // e.g., 'artist' or 'client'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * Ensures the password is automatically hashed before being stored.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // In modern Laravel, adding 'hashed' here automatically hashes the password attribute
        'password' => 'hashed',
    ];

    /**
     * Create a new member with the given data.
     * Ensures at least one contact method is provided and handles null safety.
     * 
     * @param array $data
     * @return static
     * @throws \InvalidArgumentException
     */
    public static function createNewMember(array $data)
    {
        // Validate that at least one contact method is provided
        $hasContact = !empty($data['line_id']) || !empty($data['phone_number']) || !empty($data['instagram']);
        
        if (!$hasContact) {
            throw new \InvalidArgumentException('At least one contact method (Line ID, Phone Number, or Instagram) is required.');
        }

        // Create the member with null safety
        return self::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'], // Will be automatically hashed by the 'hashed' cast
            'line_id' => !empty($data['line_id']) ? $data['line_id'] : null,
            'phone_number' => !empty($data['phone_number']) ? $data['phone_number'] : null,
            'instagram' => !empty($data['instagram']) ? $data['instagram'] : null,
            'role' => $data['role'] ?? 'client', // Default to 'client' if not specified
        ]);
    }

    /**
     * Relationship to commissions
     */
    public function commissions()
    {
        return $this->hasMany(Commission::class, 'member_id', 'member_id');
    }
}

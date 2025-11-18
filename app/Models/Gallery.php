<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'file_format',
        'status',
        'price',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * relationship to Adoption model
     */
    public function adoptions()
    {
        return $this->hasMany(Adoption::class, 'gallery_id', 'gallery_id');
    }

    /**
     * Get the active adoption (if artwork is reserved/sold)
     * Intinya: mendapatkan data adoption aktif jika artwork berstatus reserved/sold
     */
    public function activeAdoption()
    {
        return $this->hasOne(Adoption::class, 'gallery_id', 'gallery_id')
            ->whereIn('order_status', ['pending', 'confirmed', 'processing', 'delivered', 'completed'])
            ->latest();
    }

    /**
     * Check if artwork is available for adoption
     * Intinya: memeriksa apakah artwork tersedia untuk diadopsi
     */
    public function isAvailable()
    {
        return $this->status === 'available' && !$this->activeAdoption()->exists();
    }

    /**
     * method scopes untuk mengambil artworks yang tersedia
     * Intinya: mendapatkan artworks yang berstatus available dan tidak memiliki adoption aktif
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
            ->whereDoesntHave('adoptions', function ($q) {
                $q->whereIn('order_status', ['pending', 'confirmed', 'processing', 'delivered', 'completed']);
            });
    }

    /**
     * Scope to get adopted/sold artworks
     * Intinya: mendapatkan artworks yang berstatus sold atau memiliki adoption dengan order_status completed
     */
    public function scopeSold($query)
    {
        return $query->where('status', 'sold')
            ->orWhereHas('adoptions', function ($q) {
                $q->where('order_status', 'completed');
            });
    }
}

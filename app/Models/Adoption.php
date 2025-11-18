<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adoption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'adoptions';
    protected $primaryKey = 'adoption_id';

    protected $fillable = [
        'gallery_id',
        // 'buyer_name',
        // 'buyer_email',
        // 'buyer_phone',
        'email',
        'payment_confirmation',
        'order_status',
        'payment_status',
    ];

    // Relasi ke Gallery
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'gallery_id');
    }

    /**
     * Get order status color
     * pending    → 🔴 Red (waiting for artist confirmation)
     * confirmed  → 🔵 Blue (confirmed by artist)
     * processing → 🟣 Purple (preparing files)
     * delivered  → 🟠 Amber (files delivered)
     * completed  → 🟢 Green (order completed)
     * cancelled  → ⚫ Gray (cancelled)
     */
    public function getOrderStatusColorAttribute()
    {
        $colors = [
            'pending' => 'bg-red-600',      // Red - waiting for artist confirmation
            'confirmed' => 'bg-blue-500',   // Blue - confirmed by artist
            'processing' => 'bg-amber-500', // Amber - preparing files
            'delivered' => 'bg-purple-400',   // Purple - files delivered
            'completed' => 'bg-green-600',   // Green - order completed
            'cancelled' => 'bg-gray-500',    // Gray - cancelled
        ];

        return $colors[$this->order_status] ?? 'bg-gray-500';
    }

    /**
     * Get order status text (formatted/display name)
     */
    public function getOrderStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'delivered' => 'Delivered',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        return $texts[$this->order_status] ?? 'Unknown';
    }

    /**
     * Get payment status color
     * unpaid   → 🔴 Red (not paid)
     * paid     → 🟢 Green (paid)
     * refunded → 🔵 Blue (refunded)
     * failed   → ⚫ Gray (failed)
     */
    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'unpaid' => 'bg-red-600',   // Red - not paid
            'paid' => 'bg-green-600',   // Green - paid
            'refunded' => 'bg-blue-600', // Blue - refunded
            'failed' => 'bg-gray-600',   // Gray - failed
        ];

        return $colors[$this->payment_status] ?? 'bg-gray-400';
    }

    /**
     * Get payment status text (formatted/display name)
     */
    public function getPaymentStatusTextAttribute()
    {
        $texts = [
            'unpaid' => 'Unpaid',
            'paid' => 'Paid',
            'refunded' => 'Refunded',
            'failed' => 'Failed',
        ];

        return $texts[$this->payment_status] ?? 'Unknown';
    }
}

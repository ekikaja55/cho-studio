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
        'delivery_notes',
        'delivery_type',
        'delivery_file',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // Relasi ke Gallery
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'gallery_id');
    }

    public function getOrderStatusColorAttribute()
    {
        $colors = [
            'placed' => 'bg-amber-500', // Amber - preparing files
            "processing" => "bg-blue-500", // purple - processing
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
            'placed' => 'Placed',
            "processing" => "Processing",
            'delivered' => 'Delivered',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        return $texts[$this->order_status] ?? 'Unknown';
    }

    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => 'bg-red-600',   // Red - not paid
            'paid' => 'bg-green-600',   // Green - paid
            'refunded' => 'bg-blue-600', // Blue - refunded
            "invalid" => "bg-gray-600"
        ];

        return $colors[$this->payment_status] ?? 'bg-gray-400';
    }

    /**
     * Get payment status text (formatted/display name)
     */
    public function getPaymentStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'refunded' => 'Refunded',
            "invalid" => "Invalid"
        ];

        return $texts[$this->payment_status] ?? 'Unknown';
    }
}

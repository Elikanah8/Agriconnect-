<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 
        'buyer_id', 
        'farmer_id', 
        'transporter_id', // CRITICAL: Added this so the Transporter can "Accept"
        'quantity', 
        'total_price', 
        'status'
    ];

    // Relationship to the product being ordered
    public function product() 
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship to the buyer who placed the order
    public function buyer() 
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relationship to the farmer who owns the product
    public function farmer() 
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    // Relationship to the transporter who claimed the delivery
    public function transporter() 
    {
        return $this->belongsTo(User::class, 'transporter_id');
    }
}
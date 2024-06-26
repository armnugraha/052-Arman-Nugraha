<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'name',
        'total_price'
    ];
    
    /**
     * Delete data order details if self delete.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($order) {
            foreach ($order->orderDetails as $orderDetail) {
                $orderDetail->delete();
            }
        });
    }

    /**
     * One to one.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * One to many.
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}

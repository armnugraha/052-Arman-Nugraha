<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'trx_code',
        'total_price',
        'total_payment',
        'short_url',
        'full_url'
    ];

    protected $appends = ['formatted_created_at'];

    /**
     * Accessor for formatted_created_at.
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
 
    /**
     * Delete data order if self delete.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($transaction) {
            foreach ($transaction->orders as $order) {
                $order->delete();
            }
        });
    }

    /**
     * One to one.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * One to many.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}

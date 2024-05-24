<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Accessor for formatted_created_at
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}

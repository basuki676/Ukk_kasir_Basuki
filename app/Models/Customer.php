<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    // Tambahkan 'no_hp' ke dalam fillable
    protected $fillable = [
        'name',
        'no_hp', // tambahkan ini
        'point',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // protected $table = 'sale';

    protected $fillable = ['total_price', 'total_pay', 'total_return', 'customer_id', 'user_id', 'poin', 'total_poin'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function detailSales()
    {
        return $this->hasMany(DetailSale::class);
    }
}

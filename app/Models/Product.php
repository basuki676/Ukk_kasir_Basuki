<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    public function detailSales()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function sales()
    {
        return $this->hasManyThrough(
            Sale::class,
            DetailSale::class,
            'product_id', // Foreign key on DetailSale table
            'id', // Foreign key on Sale table
            'id', // Local key on Product table
            'sale_id', // Local key on DetailSale table
        );
    }
}

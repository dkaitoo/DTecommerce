<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'chosen_attribute',
    ];

    // 1 gio hang thuoc 1 user
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // gio hang thuộc sản phẩm
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}

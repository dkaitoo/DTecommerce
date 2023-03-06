<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'name',
        'identity_card',
        'store_name',
        'slug',
        'logo',
        'address',
        'phone',
        'approved'
        //thêm 1 cái check tài khoản duyệt hay chưa
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // user_id là thuộc tính này, còn id là khóa tham chiếu tới
    }

    public function product(){
        return $this->hasMany(Product::class, 'product_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_id',
        'user_id',
        'carts',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'ward',
        'message',
        'price',
        'payed',
    ];

    /**
     * Interact with the order's status.
     *
     * @return Attribute
     */
//    protected function status(): Attribute
//    {
//        return new Attribute(
//            get: fn($value)=> ['Chờ xác nhận','Đã xác nhận','Đang vận chuyển','Đã giao'][$value],
//        );
//    }

    /**
     * Interact with the order's status.
     *
     * @return Attribute
     */
    protected function payed(): Attribute
    {
        return new Attribute(
            get: fn($value)=> ['Chưa thanh toán','Đã thanh toán'][$value],
        );
    }

    // 1 don hang thuoc 1 user
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // 1 hoa don co rat nhiu san pham da them vao gio
    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}

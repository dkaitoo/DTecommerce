<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug', // tên miền
        'image',
        'description',
        'status',
        'popular',
//        'meta_title',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

//    public function brands(){
//        return $this->hasMany(Brand::class, 'category_id', 'id')->where('status', '1');
//    }

}

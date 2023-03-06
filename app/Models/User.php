<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// phải implements MustVerifyEmail
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_social',
        'type_login',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Interact with the user's role.
     *
     * @return Attribute
     */
    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value)=> ['user','seller','admin'][$value],
        );
    }

    public function profileUser()
    {
        return $this->hasOne(ProfileUser::class, 'user_id', 'id');
    }

    // nếu chưa có kích hoạt chế độ trở thành nhà bán hàng thì hk cần gọi hàm này
    public function profileSeller()
    {
        return $this->hasOne(Seller::class, 'user_id', 'id');
    }


}

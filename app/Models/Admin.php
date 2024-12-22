<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends AuthModel
{
    use SoftDeletes;

    /**
     * 可以被批量赋值的属性.
     * @var array
     */
    /*protected $fillable = [
        'account', 'password','thumb','email'
    ];*/
    protected $guarded = [];

    /**
     * 设置密码加密
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        if ($password) {
            $this->attributes['password'] = bcrypt($password);
        }

    }
}

<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kodeine\Acl\Traits\HasRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasRole, SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'nickname', 'mobile', 'level', 'card_number', 'password', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function aliases()
    {
        return $this->hasMany('App\UserAlias');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function reserves()
    {
        return $this->hasMany('App\Reserve');
    }

    public function roles()
    {
        return $this->belongsToMany('Kodeine\Acl\Models\Eloquent\Role');
    }

    public function displayStatus() {
        switch($this->attributes['status']) {
            case 'active':
                return '正常';
                break;
            case 'inactive':
                return '失效';
                break;
        }
    }

    public function displayLevel() {
        switch($this->attributes['level']) {
            case '001':
                return '非会员';
                break;
            case '002':
                return '待审核会员';
                break;
            case '003':
                return '会员';
                break;
        }
    }
}

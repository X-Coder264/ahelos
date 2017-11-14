<?php

namespace Ahelos;

use Ahelos\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use Jrean\UserVerification\Traits\UserVerification;


class User extends Authenticatable implements AuthenticatableContract
{
    use Notifiable;

    use SoftDeletes;

    use UserVerification;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'company', 'company_id', 'post', 'place', 'address', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function printers()
    {
        return $this->hasMany(Printer::class);
    }

    public function newPrinter($attributes)
    {
        return $this->printers()->create($attributes);
    }

    public function isAdmin()
    {
        return $this->admin;
    }
}

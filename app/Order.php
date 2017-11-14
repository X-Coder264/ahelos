<?php

namespace Ahelos;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'remark'
    ];
    
    public function printerOrders()
    {
        return $this->hasMany(PrinterOrder::class);
    }

}

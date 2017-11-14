<?php

namespace Ahelos;

use Illuminate\Database\Eloquent\Model;

class PrinterOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ink_id', 'order_id', 'quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ink()
    {
        return $this->hasOne(PrinterInk::class, 'id', 'ink_id');
    }
}

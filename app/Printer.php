<?php

namespace Ahelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inks()
    {
        return $this->hasMany(PrinterInk::class, 'printer_id');
    }

    public function withTrashedInks()
    {
        return $this->hasMany(PrinterInk::class, 'printer_id')->withTrashed();
    }
    
}

<?php

namespace Ahelos;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['subject', 'message', 'sender_name', 'sender_email'];
}

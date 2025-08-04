<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Freelancer extends Authenticatable
{
    use HasFactory, Notifiable;
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'verification_token',
    //     'verification_token_send_at',
    //     'email_verified_at',
    // ];
    protected $guarded = [];
}

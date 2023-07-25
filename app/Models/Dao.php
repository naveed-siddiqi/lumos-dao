<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dao extends Model
{
    use HasFactory;

    protected $fillable = ['project', 'asset', 'logo', 'accounts', 'description', 'domain', 'holders', 'approved_wallets'];
    protected $casts = [
        'accounts' => 'array'
    ];
}

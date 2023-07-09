<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staking extends Model
{
    use HasFactory;
    protected $fillable = ['public', 'amount', 'status', 'transaction_id'];

    public function investResult()
    {
        return $this->hasOne(StakingResult::class);
    }
}

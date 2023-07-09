<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakingResult extends Model
{
    use HasFactory;
    protected $fillable = ['staking_id', 'amount', 'transaction_id'];

    public function invest()
    {
        return $this->belongsTo(Staking::class);
    }
}

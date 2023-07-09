<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('wallet/investresult', [WalletController::class, 'investresult']);

<?php


function dopeBalance($accountID)
{

    $sdk = Soneso\StellarSDK\StellarSDK::getPublicNetInstance();

    $account = $sdk->requestAccount($accountID);

    $balance = 0;

    foreach ($account->getBalances() as $bal) {
        // DOPE 
        if ($bal->getAssetCode() == 'DOPE') {
            if ($bal->getBalance()) {
                $balance = $bal->getBalance();
                break;
            }
        }
    }

    return $balance;
}

function balanceComma($number = 1234.56)
{
    $number = number_format($number, 2, '.', ',');
    return $number;
}

function number_format_short($n, $precision = 1)
{
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
    // Intentionally does not affect partials, eg "1.50" -> "1.50"
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }
    return floor($n_format)  . $suffix;
}

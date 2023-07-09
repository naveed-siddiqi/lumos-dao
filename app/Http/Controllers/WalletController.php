<?php

namespace App\Http\Controllers;

use App\Models\Staking;
use App\Models\StakingResult;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Soneso\StellarSDK\AssetTypeCreditAlphanum4;
use Soneso\StellarSDK\Crypto\KeyPair;
use Soneso\StellarSDK\Memo;
use Soneso\StellarSDK\Network;
use Soneso\StellarSDK\PaymentOperationBuilder;
use Soneso\StellarSDK\Signer;
use Soneso\StellarSDK\StellarSDK;
use Soneso\StellarSDK\Transaction;
use Soneso\StellarSDK\TransactionBuilder;
use Soneso\StellarSDK\Xdr\XdrDecoratedSignature;
use Soneso\StellarSDK\Xdr\XdrSigner;

class WalletController extends Controller
{
    private $sdk, $minAmount, $maxFee, $returnDays;

    public function __construct()
    {
        $this->sdk = StellarSDK::getPublicNetInstance();
        $this->minAmount = env('MIN_AMOUNT');
        $this->returnDays = env('RETURN_DAYS');
        $this->maxFee = 3000;
    }

    public function store(Request $request)
    {
        if (empty($request->public) || empty($request->wallet)) {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong!']);
        }

        // Check Stellar Account
        try {
            $account = $this->sdk->requestAccount($request->public);
        } catch (Exception $th) {
            return response()->json(['status' => 0, 'msg' => 'Deposit 5 XLM lumens into your wallet!']);
        }

        $dope = null;
        $lowAmount = null;

        // foreach ($account->getBalances() as $bal) {
        //     if ($bal->getAssetCode() == 'DOPE') {
        //         $dope = 1;
        //         if ($bal->getBalance() < $this->minAmount) {
        //             $lowAmount = 1;
        //         }
        //     }
        // }

        // if (!$dope) {
        //     return response()->json(['status' => 0, 'msg' => 'Account does not have DOPE trusline!']);
        // }

        $data = [
            'public' => $request->public,
            'wallet' => $request->wallet
        ];

        // Store Stellar Account if not exist
        $wallet = Wallet::where('public', $request->public)->first();
        if (!$wallet) {
            Wallet::create($data);
        } else {
            $wallet->update($data);
        }

        setcookie('public', $request->public, time() + (86400 * 30), "/");
        setcookie('wallet', $request->wallet, time() + (86400 * 30), "/");

        return response()->json(['lowAmount' => $lowAmount, 'balance' => balanceComma(dopeBalance($request->public)), 'public' => $request->public, 'msg' => 'Connection successfull!', 'status' => 1]);
    }

    public function secret(Request $request)
    {
        if (empty($request->key)) {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong!']);
        }

        $keypair = KeyPair::fromSeed($request->key);

        // Check Stellar Account
        try {
            $account = $this->sdk->requestAccount($keypair->getAccountId());
        } catch (Exception $th) {
            return response()->json(['status' => 0, 'msg' => 'Deposit 5 XLM lumens into your wallet!']);
        }

        $dope = null;
        $lowAmount = null;

        foreach ($account->getBalances() as $bal) {
            if ($bal->getAssetCode() == 'DOPE') {
                $dope = 1;
                if ($bal->getBalance() < $this->minAmount) {
                    $lowAmount = 1;
                }
            }
        }

        if (!$dope) {
            return response()->json(['status' => 0, 'msg' => 'Account does not have DOPE trusline!']);
        }

        $data = [
            'secret' => $request->key,
            'public' => $keypair->getAccountId(),
            'wallet' => 'privatekey'
        ];

        // Store Stellar Account if not exist
        $wallet = Wallet::where('public', $keypair->getAccountId())->first();
        if (!$wallet) {
            Wallet::create($data);
        } else {
            $wallet->update($data);
        }

        setcookie('public', $keypair->getAccountId(), time() + (86400 * 30), "/");
        setcookie('wallet', 'privatekey', time() + (86400 * 30), "/");

        return response()->json(['lowAmount' => $lowAmount, 'balance' => balanceComma(dopeBalance($keypair->getAccountId())), 'public' => $keypair->getAccountId(), 'msg' => 'Connection successfull!', 'status' => 1]);
    }

    public function disconnect()
    {
        Cookie::queue(Cookie::forget('public'));
        Cookie::queue(Cookie::forget('wallet'));
        return redirect('/');
    }

    // staking XDR GENERATE
    public function invest(Request $request)
    {
        if (!isset($_COOKIE['public'])) {
            return response()->json(['status' => 0, 'msg' => 'Wallet Address not Found!']);
        }
        $wallet = Wallet::where('public', $_COOKIE['public'])->first();

        // Check Stellar Account
        try {
            $account = $this->sdk->requestAccount($_COOKIE['public']);
        } catch (Exception $th) {
            return response()->json(['status' => 0, 'msg' => 'Deposit 5 XLM lumens into your wallet!']);
        }

        $dope = null;
        $lowAmount = null;

        foreach ($account->getBalances() as $bal) {
            if ($bal->getAssetCode() == 'DOPE') {
                $dope = 1;
                if ($bal->getBalance() < $request->amount) {
                    $lowAmount = 1;
                }
            }
        }

        if (!$dope) {
            return response()->json(['status' => 0, 'msg' => 'Account does not have DOPE trusline!']);
        }

        if ($lowAmount) {
            return response()->json(['status' => 0, 'msg' => 'Not enough DOPE Tokens!']);
        }

        $data = array(
            'public' => $_COOKIE['public'],
            'amount' => $request->amount,
            'status' => 0
        );

        $invest = Staking::create($data);

        if (empty($wallet->secret)) {
            $xdr = $this->stakePublic($wallet, $request->amount);
        } else {
            $xdr = $this->stakeSecret($wallet, $request->amount);
        }

        // Operation failed
        if (!$xdr) {
            $invest->delete();
            return response()->json(['status' => 0, 'msg' => 'Something went wrong!']);
        }

        return response()->json(['xdr' => $xdr, 'status' => 1, 'staking_id' => $invest->id]);
    }

    private function stakePublic($wallet, $amount)
    {
        try {

            // Destination Account
            $mainSecret = env('MAIN_WALLET');
            $mainPair = KeyPair::fromSeed($mainSecret);

            $account = $this->sdk->requestAccount($wallet->public);

            $assetCode = 'DOPE';
            $assetIssuer = 'GA6XXNKX5LYLZGZ2QM5CHLZ4R66P4OC6UD7APNLRWRHSILUNIVZ7B4YB';
            $asset = new AssetTypeCreditAlphanum4($assetCode, $assetIssuer);
            // Payment Operation
            $paymentOperation = (new PaymentOperationBuilder($mainPair->getAccountId(), $asset, $amount))->build();
            $txbuilder = new TransactionBuilder($account);
            $txbuilder->setMaxOperationFee($this->maxFee);
            $transaction = $txbuilder->addOperation($paymentOperation)->addMemo(new Memo(1, 'DOPE staking'))->build();
            $signer = Signer::preAuthTx($transaction, Network::public());
            $sk = new XdrSigner($signer, 1);
            $transaction->addSignature(new XdrDecoratedSignature('sign', $sk->encode()));
            $response = $transaction->toEnvelopeXdrBase64();

            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }
    private function stakeSecret($wallet, $amount)
    {
        try {

            // Destination Account
            $mainSecret = env('MAIN_WALLET');
            $mainPair = KeyPair::fromSeed($mainSecret);

            $account = $this->sdk->requestAccount($wallet->public);
            $sourcePair = KeyPair::fromSeed($wallet->secret);

            $assetCode = 'DOPE';
            $assetIssuer = 'GA6XXNKX5LYLZGZ2QM5CHLZ4R66P4OC6UD7APNLRWRHSILUNIVZ7B4YB';
            $asset = new AssetTypeCreditAlphanum4($assetCode, $assetIssuer);
            // Payment Operation
            $paymentOperation = (new PaymentOperationBuilder($mainPair->getAccountId(), $asset, $amount))->build();
            $txbuilder = new TransactionBuilder($account);
            $txbuilder->setMaxOperationFee($this->maxFee);
            $transaction = $txbuilder->addOperation($paymentOperation)->addMemo(new Memo(1, 'DOPE staking'))->build();
            $transaction->sign($sourcePair, Network::public());
            $response = $transaction->toEnvelopeXdrBase64();

            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }

    // XDR SUBMIT
    public function submitXdr(Request $request)
    {
        $xdr = $request->xdr;
        $invest = Staking::where('id', $request->staking_id)->first();
        if (!$invest) {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong!']);
        }
        try {
            $sdk = $this->sdk;
            $tx = Transaction::fromEnvelopeBase64XdrString($xdr);
            if (!empty($tx->getSignatures()[1])) {
                $tx->setSignatures([$tx->getSignatures()[1]]);
            }
            $result = $sdk->submitTransaction($tx);
            $txID = $result->getId();
            if ($txID) {
                $invest->transaction_id = $txID;
                $invest->save();
                Session::flash('fxdr', $txID);
            }
            return response()->json(['status' => 1, 'msg' => 'Success!']);
        } catch (\Throwable $th) {
            $invest->delete();
            return response()->json(['status' => 0, 'msg' => 'Failed!']);
        }
    }

    public function investresult()
    {
        // removes NULL
        Staking::whereNull('transaction_id')->delete();

        $invests =  Staking::whereNotNull('transaction_id')
            ->where('status', 0)
            // ->whereRaw('MINUTE(created_at) < 1')
            ->where('created_at', '<=', now()->subDays($this->returnDays)->endOfDay())
            ->get();

        // Looping through staking
        foreach ($invests as $key => $invest) {
            $result = $this->returnStaking($invest);
            if ($result) {
                $invest->status = 1;
                $invest->save();
                StakingResult::create(['staking_id' => $invest->id, 'amount' => $result->amount, 'transaction_id' => $result->tx]);
            }
        }
        return response()->json([$invests]);
    }

    private function returnStaking($invest)
    {
        $amount = $invest->amount + (($invest->amount / 100) * 2);
        try {
            // Destination Account
            $mainSecret = env('MAIN_WALLET');
            $mainPair = KeyPair::fromSeed($mainSecret);

            $mainAccount = $this->sdk->requestAccount($mainPair->getAccountId());
            $account = $this->sdk->requestAccount($invest->public);

            $assetCode = 'DOPE';
            $assetIssuer = 'GA6XXNKX5LYLZGZ2QM5CHLZ4R66P4OC6UD7APNLRWRHSILUNIVZ7B4YB';
            $asset = new AssetTypeCreditAlphanum4($assetCode, $assetIssuer);
            // Payment Operation
            $paymentOperation = (new PaymentOperationBuilder($account->getAccountId(), $asset, $amount))->build();
            $txbuilder = new TransactionBuilder($mainAccount);
            $txbuilder->setMaxOperationFee($this->maxFee);
            $transaction = $txbuilder->addOperation($paymentOperation)->addMemo(new Memo(1, 'DOPE staking return'))->build();
            $transaction->sign($mainPair, Network::public());
            $res = $this->sdk->submitTransaction($transaction);
            return (object)['tx' => $res->getId(), 'amount' => $amount];
        } catch (\Throwable $th) {
            return null;
        }
    }
}

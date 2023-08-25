<?php

namespace App\Http\Controllers;

use App\Models\Dao;
use App\Models\Proposal;
use App\Models\Wallet;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Soneso\StellarSDK\Asset;
use Soneso\StellarSDK\AssetTypeCreditAlphanum12;
use Soneso\StellarSDK\Crypto\KeyPair;
use Soneso\StellarSDK\Memo;
use Soneso\StellarSDK\Network;
use Soneso\StellarSDK\PaymentOperationBuilder;
use Soneso\StellarSDK\Signer;
use Soneso\StellarSDK\StellarSDK;
use Soneso\StellarSDK\TransactionBuilder;
use Soneso\StellarSDK\Xdr\XdrDecoratedSignature;
use Soneso\StellarSDK\Xdr\XdrSigner;

class ProposalController extends Controller
{
    private $sdk;

    public function __construct()
    {
        $this->sdk = StellarSDK::getPublicNetInstance();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proposal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($dao_id)
    {
        $dao = Dao::findOrFail($dao_id);
        return view('proposal.create', compact('dao'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($dao_id, Request $request)
    {
        if (!isset($_COOKIE['public'])) {
            return redirect()->back()->withErrors(['msg' => 'Wallet Address not Found!'])->withInput($request->input());
        }
        $request->validate([
            'title' => 'required',
            'about' => 'required',
            'start_date' => 'required|date'
        ]);
        $wallet = Wallet::where('public', $_COOKIE['public'])->first();

        // Check Stellar Account
        try {
            $account = $this->sdk->requestAccount($_COOKIE['public']);
        } catch (Exception $th) {
            return redirect()->back()->withErrors(['msg' => 'You must have enough XLM to meet the minimum balance requirement!'])->withInput($request->input());
        }

        $amount = 0.00001;
        if (empty($wallet->secret)) {
            $xdr = $this->stakePublic($wallet, $amount, $account);
        } else {
            $xdr = $this->stakeSecret($wallet, $amount, $account);
        }

        $request['dao_id'] = $dao_id;

        $startDate = new DateTime($request->start_date);

        // Add 10 days to the start date
        $startDate->add(new DateInterval('P10D'));

        $request['end_date'] = $startDate->format('Y-m-d');

        Proposal::create($request->all());
        return redirect()->route('dao', $dao_id);
    }

    private function stakePublic($wallet, $amount, $account)
    {
        try {
            // Destination Account
            $mainSecret = env('MAIN_WALLET');
            $mainPair = KeyPair::fromSeed($mainSecret);

            // $assetCode = 'LUMOS';
            // $assetIssuer = 'GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P';
            // $asset = new AssetTypeCreditAlphanum12($assetCode, $assetIssuer);
            // Payment Operation
            $paymentOperation = (new PaymentOperationBuilder($mainPair->getAccountId(), Asset::native(), $amount))->build();
            $txbuilder = new TransactionBuilder($account);
            // $txbuilder->setMaxOperationFee($this->maxFee);
            $transaction = $txbuilder->addOperation($paymentOperation)->addMemo(new Memo(1, 'Proposal creating'))->build();
            $signer = Signer::preAuthTx($transaction, Network::public());
            $sk = new XdrSigner($signer, 1);
            $transaction->addSignature(new XdrDecoratedSignature('sign', $sk->encode()));
            $response = $transaction->toEnvelopeXdrBase64();

            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }

    private function stakeSecret($wallet, $amount, $account)
    {
        try {
            // Destination Account
            $mainSecret = env('MAIN_WALLET');
            $mainPair = KeyPair::fromSeed($mainSecret);

            $sourcePair = KeyPair::fromSeed($wallet->secret);

            // Payment Operation
            $paymentOperation = (new PaymentOperationBuilder($mainPair->getAccountId(), Asset::native(), $amount))->build();
            $txbuilder = new TransactionBuilder($account);
            $transaction = $txbuilder->addOperation($paymentOperation)->addMemo(new Memo(1, 'Proposal creating'))->build();
            $transaction->sign($sourcePair, Network::public());
            $response = $transaction->toEnvelopeXdrBase64();

            return $response;
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

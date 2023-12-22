<?php

namespace App\Http\Controllers;

use App\Models\Dao;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Yosymfony\Toml\Toml;

class DaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($dao_id)
    {
       return view('dao.index', compact('dao_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dao.create');
    }

    public function search(Request $request) {
        $client = new Client();
        $domain = $request->home_domain;
        $code = $request->asset_code;
        $url = 'https://'.$domain.'/.well-known/stellar.toml';
        $data = ['domain'=>$domain, 'code'=>$code];
        if ($domain && $code) {
            try {
                // try {
                    $response = $client->get($url);
                // } catch (\Throwable $th) {
                //     $data += ['error_key'=>'domain'];
                // }
                $content = $response->getBody()->getContents();
                $toml = Toml::parse($content);
                // if ( isset($toml['ACCOUNTS']) && in_array($_COOKIE['public'], $toml['ACCOUNTS']) ) {
                if ( ( isset($toml['ACCOUNTS']) && in_array($_COOKIE['public'], $toml['ACCOUNTS']) ) || $_COOKIE['public']==env('DEVELOPER_WALLET') ) {
                    if ( in_array($code, array_column($toml['CURRENCIES'], 'code')) ) {
                        $data += ['toml'=>$toml];
                    } else {
                        $data += ['error_key'=>'code'];
                    }
                } else {
                    $data += ['error_key'=>'permission'];
                }
            } catch (\Throwable $th) {
                $data += ['error_key'=>'domain'];
            }

            // $response = Http::get('https://horizon.stellar.org/assets', [
            //     'asset_code' => $code,
            //     'domain' => $domain,
            // ]);
            // if ($response->ok()) {
            //     $accounts = $response->json();
            //     if ( !empty($accounts['_embedded']['records']) ) {
            //         foreach ($accounts['_embedded']['records'] as $account) {
            //             echo 'Account ID: ' . $account['account_id'] . PHP_EOL;
            //             echo 'Balance: ' . $account['balances'][0]['balance'] . PHP_EOL;
            //         }
            //     } else {
            //         echo 'No Trustlines found for the asset and domain.';
            //     }
            // } else {
            //     echo 'Error fetching Trustlines: ' . $response->status();
            // }

            // try {
            //     $response = $client->get('https://horizon.stellar.org/assets?asset_code='.$code.'&domain='.$domain);
            //     $content2 = $response->getBody()->getContents();
            // } catch (\Throwable $th) {
            //     throw $th;
            // }
            // dd($content2);
        } else {
            $data += ['error_key'=>'blank'];
        }

        return back()->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request['approved_wallets'] = $request->approved_wallets ? $request->approved_wallets : [];
        Dao::create($request->all());
        return response()->json(['status' => 1, 'msg' => 'DAO created successfully!']);
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

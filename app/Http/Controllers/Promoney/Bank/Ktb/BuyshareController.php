<?php

namespace App\Http\Controllers\Promoney\Bank\Ktb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class BuyshareController extends Controller
{
    private $client;
    private $headers;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => config('api.coop_base_uri')]);
        $this->headers['x-api-version'] = config('api.coop_api_version');
        $this->headers['x-api-key'] = config('api.coop_api_key');
    }

    public function inquiry(Request $request)
    {
        if (!$request->hasHeader('coop-access-token')) {
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        $this->validate($request, [
            // 'from_bay_account_no' => 'required',
            'transaction_amount' => 'required',

        ]);

        $url = "/ktb/cgp/transaction/Inquiry/";
        $transactionType = 'buyshare';
        $user = Auth::user()->MemRegis;

        $data = [
            'member_code' => Auth::user()->membership_no,
            'citizen_no' => $user->ID_CARD,
            'from_coop_account_no' => '',
            'from_bay_account_no' => '06',
            'to_coop_account_no' => '',
            'to_bay_account_no' => '',
            'transaction_amount' => $request->transaction_amount,
            'transaction_fee' => 0,
            'note' => $request->note ? $request->note  : ''


        ];

        $this->headers['Authorization'] = 'Bearer ' . $request->header('coop-access-token');

        return $this->respondWithApi('POST', $url . $transactionType, [
            'verify' => false,
            'headers' => $this->headers,
            'json' => $data
        ]);
    }

    public function confirmation(Request $request)
    {
        if (!$request->hasHeader('coop-access-token')) {
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        $this->validate($request, [
            'from_bay_account_no' => 'required',
            'transaction_amount' => 'required',
            'transaction_id' => 'required',
        ]);

        $url = "/ktb/cgp/transaction/confirmations/";
        $transactionType = 'buyshare';
        $user = Auth::user()->MemRegis;

        $data = [
            'member_code' => Auth::user()->membership_no,
            'citizen_no' => $user->ID_CARD,
            'from_coop_account_no' => '',
            'from_bay_account_no' => $request->from_bay_account_no,
            'to_coop_account_no' => '',
            'to_bay_account_no' => '',
            'transaction_amount' => $request->transaction_amount,
            'transaction_fee' => 0,
            'note' => $request->note ? $request->note  : '',
            'transaction_id' => $request->transaction_id
        ];

        $this->headers['Authorization'] = 'Bearer ' . $request->header('coop-access-token');

        return $this->respondWithApi('POST', $url . $transactionType, [
            'verify' => false,
            'headers' => $this->headers,
            'json'  => $data
        ]);
    }

    protected function respondWithApi($medthod, $uri = '', array $options = [])
    {
        try {
            $options['cookies'] = new FileCookieJar(storage_path('/app/cookies/') . 'cookies.json');
            $response = $this->client->request($medthod, $uri, $options);
            return response()->json(json_decode((string) $response->getBody()), $response->getStatusCode());
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse();
            }
            return response()->json(['code' => 'CWL0002ERROR', 'message' => $e->getMessage()], 500);
        }
        return response()->json(['code' => 'CWL0002ERROR', 'message' => 'Internal COOP Error'], 500);
    }
}
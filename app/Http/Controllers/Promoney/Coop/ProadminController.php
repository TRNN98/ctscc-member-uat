<?php

namespace App\Http\Controllers\Promoney\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class ProadminController extends Controller
{
    private $client;
    private $headers;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => config('api.coop_base_uri')]);
        $this->headers['x-api-version'] = config('api.coop_api_version');
        $this->headers['x-api-key'] = config('api.coop_api_key');
    }

    public function loanpermit(Request $request)
    {
        if (!$request->hasHeader('coop-access-token')) {
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        $this->validate($request, [
            'loan_type' => 'required',
            'salary' => 'required',
            'expense' => 'required',
            'income' => 'required',
            'type' => 'required',

        ]);

        $url = "/proadmin/calcloanpermit";
        // $user = Auth::user()->MemRegis;

        $data = [
            'member_code' => Auth::user()->membership_no,
            'loan_type' => $request->loan_type,
            'salary' => $request->salary,
            'expense' => $request->expense,
            'income' => $request->income,
            'type' => $request->type,
            'academic' => $request->academic,
            'back_pay' => $request->back_pay,
            'coop' => $request->coop,
            'net' => $request->net,
        ];
        // dd($data);

        $this->headers['Authorization'] = 'Bearer ' . $request->header('coop-access-token');

        return $this->respondWithApi('POST', $url, [
            'verify' => false,
            'headers' => $this->headers,
            'json' => $data
        ]);
    }

    public function loanpermitinstall(Request $request)
    {
        if (!$request->hasHeader('coop-access-token')) {
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        $this->validate($request, [
            'loan_type' => 'required',
            'paytype' => 'required',
            'caltype' => 'required',
            'permit' => 'required',
            'install' => 'required',
            'payment' => 'required',
        ]);

        $url = "/proadmin/calcloanpermitinstall";
        // $user = Auth::user()->MemRegis;

        $data = [
            'member_code' => Auth::user()->membership_no,
            'loan_type' => $request->loan_type,
            'paytype' => $request->paytype,
            'caltype' => $request->caltype,
            'permit' => $request->permit,
            'install' => $request->install,
            'payment' => $request->payment,
        ];
        // dd($data);

        $this->headers['Authorization'] = 'Bearer ' . $request->header('coop-access-token');

        return $this->respondWithApi('POST', $url, [
            'verify' => false,
            'headers' => $this->headers,
            'json' => $data
        ]);
    }

    public function validateChangeShare(Request $request)
    {
        if (!$request->hasHeader('coop-access-token')) {
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        // as_dropstatus char default '2'  ,adc_sharemonthly number,adt_opdate date

        $this->validate($request, [
            'dropstatus' => 'required',
            // 'sharemonthly' => 'required',
        ]);

        $url = "/proadmin/vdChangeShare";
        // $user = Auth::user()->MemRegis;

        $data = [
            'member_code' => Auth::user()->membership_no,
            'dropstatus' => $request->dropstatus,
            'sharemonthly' => $request->sharemonthly ?? null,
        ];

        $this->headers['Authorization'] = 'Bearer ' . $request->header('coop-access-token');

        return $this->respondWithApi('POST', $url, [
            'verify' => false,
            'headers' => $this->headers,
            'json' => $data
        ]);
    }

    protected function respondWithApi($medthod, $uri = '', array $options = [])
    {
        try {
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

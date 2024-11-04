<?php

namespace App\Http\Controllers\Promoney\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
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
            return response()->json(
                [
                    'code' => 'CWL0003ERROR',
                    'message' => 'ทำรายการไม่สำเร็จ',
                    'errors' => ['coop-access-token' => 'The given data was invalid.']
                ],
                403
            );
        }

        $url = "/account/inquiry";
        $user = Auth::user()->MemRegis;

        $data = [
            'member_code' => Auth::user()->membership_no,
            'citizen_no' => $user->ID_CARD,
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

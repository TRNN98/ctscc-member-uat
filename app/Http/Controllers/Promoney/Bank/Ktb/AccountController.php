<?php

namespace App\Http\Controllers\Promoney\Bank\Ktb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Cookie\FileCookieJar;
use Illuminate\Support\Facades\Auth;
// use App\Model\member\api\Member as User;

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
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        $url = "/ktb/cgp/request";
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

    public function unlink(Request $request)
    {
        if (!$request->hasHeader('coop-access-token')) {
            return response()->json(['code' => 'CWL0003ERROR', 'message' => 'ทำรายการไม่สำเร็จ', 'errors' => ['coop-access-token' => 'The given data was invalid.']], 422);
        }

        $url = "/ktb/cgp/revoke";
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
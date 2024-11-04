<?php

namespace App\Http\Controllers\Promoney\Coop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Cookie\FileCookieJar;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticateController extends Controller
{
    private $client;
    private $headers;

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['base_uri' => config('api.coop_base_uri')]);
        $this->headers['x-api-version'] = config('api.coop_api_version');
        $this->headers['x-api-key'] = config('api.coop_api_key');
    }

    public function token(Request $request)
    {
        $url = "/oauth/token";

        $data = [
            "grant_type" => "client_credentials",
            "client_id" => config('api.coop_client_id'),
            "client_secret" => config('api.coop_client_secret'),
        ];
        // dd($request);
        // ===== check sm_member_filter_used by ohm 30/08/2564 =========
        $check_mode = DB::table("www_constant")->pluck('www_promoney_softlaunch')->first();
        // ถ้าเป็น 1 คือ เปิดโหมด softlaunch ถ้าเป็น 0 จะหลุด if
        if ($check_mode == 1) {
            $check_member_filter_used =  DB::select("SELECT *
                                                    FROM sm_member_filter_used
                                                    WHERE membership_no = '" . Auth::user()->membership_no . "'
                                                    AND promoney_active = 1");
            if (count($check_member_filter_used) == 0) {
                return response()->json(['code' => 'CWL0002ERROR', 'message' => 'ขออภัยในความไม่สะดวก ระบบอยู่ระหว่างการทดสอบ ไม่สามารถใช้งานได้ชั่วคราว'], 401);
            }
        }
        // dd($request);
        // ====== ================================= ===========
        try {
            $cooptoken = $this->respondWithApi('POST', $url, [
                'verify' => false,
                'headers' => $this->headers,
                'form_params'  => $data
            ]);

            return response()->json(['code' => 'CWL200SUCCESS', 'message' => 'ทำรายการสำเร็จ', 'result' => ['coopToken' => $cooptoken->getData()]], 200);

            // if ($cooptoken->status() === 200) {
            //     $this->headers['Authorization'] = 'Bearer ' . $cooptoken->getData()->access_token;
            //     $baytoken = $this->respondWithApi('POST', '/bay/token', [
            //         'verify' => false,
            //         'headers' => $this->headers,
            //         'json'  => $data
            //     ]);
            //     if ($baytoken->status() === 200) {
            //         return response()->json(['code' => 'CWL200SUCCESS', 'message' => 'ทำรายการสำเร็จ', 'result' => ['coopToken' => $cooptoken->getData(), 'bayToken' => $baytoken->getData()->result]], 200);
            //     }
            // }
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['code' => 'CWL0002ERROR', 'message' => 'Internal COOP Error catch'], 500);
        }
        return response()->json(['code' => 'CWL0002ERROR', 'message' => 'Internal COOP Error'], 500);
    }

    protected function respondWithApi($medthod, $uri = '', array $options = [])
    {
        try {
            $options['cookies'] = new FileCookieJar(storage_path('app/cookies/') . 'cookies.json');
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

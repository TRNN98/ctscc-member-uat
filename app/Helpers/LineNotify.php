<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\HTTPClient\GuzzleHTTPClient;

class LineNotify extends LINEBot
{

    public function __construct()
    {

        $this->config = [
            'channelId' => config('linebot.CHANNEL_ID'),
            'channelSecret' => config('linebot.CHANNEL_SECRET'),
        ];

        $httpClient = new CurlHTTPClient($this->config['channelId']);
        // $this->line = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->config->channelSecret]);

        parent::__construct($httpClient, ['channelSecret' => $this->config['channelSecret']]);
    }

    public function send($line)
    {
        if ($line->isSucceeded()) {
            // echo 'Succeeded!';
            return true;
        }

        // Failed
        // echo $line->getHTTPStatus() . ' ' . $line->getRawBody();
        return false;
    }
}

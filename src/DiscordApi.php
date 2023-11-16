<?php

namespace Asymetricdata\DiscordRestPhp;

use Asymetricdata\DiscordRestPhp\Resources\Guild;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class DiscordApi
{
    public Client $client;

    public function __construct(
        public readonly string $token,
        public readonly int $api_version,
        public readonly string $api_endpoint,
        public readonly string $user_agent = "AsymetricData\DiscordApi",
    )
    {
        $this->client = new Client();
    }

    public function get(string $url) : ResponseInterface
    {
        return $this->client->request('GET',$this->api_endpoint . '/v'. $this->api_version . '/' . $url,[
            'headers' => [
                'Authorization' => ' Bot ' . $this->token,
                'User-Agent' => $this->user_agent,
            ]
        ]);
    }

    public function guild(string $id) : Guild
    {
        return new Guild($this,$id);
    }

}

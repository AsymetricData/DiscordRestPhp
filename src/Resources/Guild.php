<?php

namespace Asymetricdata\DiscordRestPhp\Resources;

use Asymetricdata\DiscordRestPhp\DiscordApi;
use Exception;

class Guild implements ResourceInterface
{
    public string $resource = 'guilds';
    private readonly DiscordApi $api;

    /**
     * @var ?string Guild id
     */
    public readonly ?string $id;

    public readonly ?string $name;
    public readonly ?string $icon;
    public readonly ?string $description;
    public readonly ?string $splash;
    public readonly ?string $discovery_splash;
    public readonly ?int $approximate_member_count;
    public readonly ?int $approximate_presence_count;

    public readonly ?string $banner;
    public readonly ?string $owner_id;
    public readonly ?string $application_id;

    public readonly ?string $region;
    public readonly ?string $afk_channel_id;

    public readonly ?int $afk_timeout;

    public function __construct(DiscordApi &$api, string $id, bool $withCounts = true)
    {
        $this->api = $api;

        $response = $this->api->get($this->resource . '/' . $id .'?with_counts='. $withCounts);

        $json = json_decode($response
                        ->getBody()
                        ->getContents());

        foreach(get_object_vars($json) as $field => $value){
            if(property_exists(self::class,$field)){
                $this->$field = $value;
            }
        }

    }
    /**
     * GET/guilds/{guild.id}/channels
     * Returns a list of guild channel objects. Does not include threads.
     * @return array $channels
     */
    public function getChannels() : array
    {
        $id ??= $this->id ?? throw new Exception("You must get the resources before calling the method");

        $response = $this->api->get($this->resource . '/' . $this->id . '/channels');
        return json_decode($response->getBody()->getContents());
    }

    /**
     * GET/guilds/{guild.id}/members
     * Returns a list of guild member objects that are members of the guild.
     * @return array<Member> $members
     */
    public function listMembers(?int $limit = null, ?string $after = "0" ) : array
    {   
      $members = [];
  
      $max_call = ceil(($limit ?? $this->approximate_member_count) / 1000); 

      for($i = 0; $i < $max_call; $i++){
        $response = $this->api->get($this->resource . '/' . $this->id . '/members', [
          'query' => [
            'limit' => $limit ?? 1000,
            'after' => $after,
          ],
        ]);

        foreach(json_decode($response->getBody()->getContents()) as $key => $member){
          $members[] = new Member($this->api,get_object_vars($member));
        }

        $after = $members[array_key_last($members)]->user->id;

      }
      return $members;
    }
}

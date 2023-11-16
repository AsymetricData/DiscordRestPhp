<?php

namespace Asymetricdata\DiscordRestPhp\Resources;

use Asymetricdata\DiscordRestPhp\DiscordApi;
use Exception;

/* {
    "id": "2909267986263572999",
    "name": "Mason's Test Server",
    "icon": "389030ec9db118cb5b85a732333b7c98",
    "description": null,
    "splash": "75610b05a0dd09ec2c3c7df9f6975ea0",
    "discovery_splash": null,
    "approximate_member_count": 2,
    "approximate_presence_count": 2,
    "features": [
      "INVITE_SPLASH",
      "VANITY_URL",
      "COMMERCE",
      "BANNER",
      "NEWS",
      "VERIFIED",
      "VIP_REGIONS"
    ],
    "emojis": [
      {
        "name": "ultrafastparrot",
        "roles": [],
        "id": "393564762228785161",
        "require_colons": true,
        "managed": false,
        "animated": true,
        "available": true
      }
    ],
    "banner": "5c3cb8d1bc159937fffe7e641ec96ca7",
    "owner_id": "53908232506183680",
    "application_id": null,
    "region": null,
    "afk_channel_id": null,
    "afk_timeout": 300,
    "system_channel_id": null,
    "widget_enabled": true,
    "widget_channel_id": "639513352485470208",
    "verification_level": 0,
    "roles": [
      {
        "id": "2909267986263572999",
        "name": "@everyone",
        "permissions": "49794752",
        "position": 0,
        "color": 0,
        "hoist": false,
        "managed": false,
        "mentionable": false
      }
    ],
    "default_message_notifications": 1,
    "mfa_level": 0,
    "explicit_content_filter": 0,
    "max_presences": null,
    "max_members": 250000,
    "max_video_channel_users": 25,
    "vanity_url_code": "no",
    "premium_tier": 0,
    "premium_subscription_count": 0,
    "system_channel_flags": 0,
    "preferred_locale": "en-US",
    "rules_channel_id": null,
    "public_updates_channel_id": null,
    "safety_alerts_channel_id": null
  } */

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

    public function __construct(DiscordApi &$api, string $id)
    {
        $this->api = $api;

        $response = $this->api->get($this->resource . '/' . $id .'?with_counts='. true);

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
    public function getMembers() : array
    {   
        $response = $this->api->get($this->resource . '/' . $this->id . '/members');

        $members = [];
        foreach(json_decode($response->getBody()->getContents()) as $key => $member){
          $members[] = new Member($this->api,get_object_vars($member));
        }
        return $members;
    }
}

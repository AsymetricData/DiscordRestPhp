<?php

namespace Asymetricdata\DiscordRestPhp\Resources;

use Asymetricdata\DiscordRestPhp\DiscordApi;
use Exception;

class Member implements ResourceInterface
{
    public string $resource = 'members';
    private readonly DiscordApi $api;

    public readonly ?string $avatar;
    public readonly ?string $communication_disabled_until;
    public readonly ?int $flags;
    public readonly ?string $joined_at;
    public readonly ?string $nick;
    public readonly ?bool $pending;
    public readonly ?int $premium_since;
    /** @var array<Role> */
    public readonly ?array $roles;
    public readonly ?string $unusual_dm_activity_until;
    public readonly ?bool $mute;
    public readonly ?bool $deaf;


    public readonly ?User $user;

    public function __construct(DiscordApi &$api, array $fields)
    {
        $this->api = $api;

        foreach ($fields as $field => $value) {
            if (property_exists(self::class, $field)) {
                if ($field == 'user') {
                    $this->user = new User(get_object_vars($value));
                }else{
                    $this->$field = $value;
                }
            }
        }
    }
}

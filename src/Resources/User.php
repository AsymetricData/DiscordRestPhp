<?php

namespace Asymetricdata\DiscordRestPhp\Resources;

use Asymetricdata\DiscordRestPhp\DiscordApi;

class User implements ResourceInterface
{
    public string $resource = 'users';
    private readonly DiscordApi $api;

    /**
     * @var ?string Member id
     */
    public readonly ?string $id;

    public readonly ?string $username;
    public readonly ?string $icon;
    public readonly ?string $avatar;
    public readonly ?string $discriminator;
    public readonly ?int $premium_type;
    public readonly ?int $flags;
    public readonly ?string $accent_color;
    public readonly ?string $global_name;
    public readonly ?object $avatar_decoration_data;
    public readonly ?string $banner_color;

    public function __construct(array $fields)
    {
        foreach ($fields as $field => $value) {
            if (property_exists(self::class, $field)) {
                $this->$field = $value;
            }
        }
    }
}

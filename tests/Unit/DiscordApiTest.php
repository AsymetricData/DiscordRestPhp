<?php

use Asymetricdata\DiscordRestPhp\DiscordApi;
use Asymetricdata\DiscordRestPhp\Resources\Guild;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->safeLoad();

$discord_api = new DiscordApi(
    token: $_ENV['DISCORD_BOT_TOKEN'],
    api_version: $_ENV['DISCORD_API_VERSION'],
    api_endpoint: $_ENV['DISCORD_API_ENDPOINT'],
);

test('canGetGuild', function () use($discord_api) {
    expect($discord_api->guild($_ENV['TEST_GUILD_ID']))->toBeInstanceOf(Guild::class);
});

test('canGetMembers', function () use($discord_api) {
    $guild = $discord_api->guild($_ENV['TEST_GUILD_ID']);
    expect($guild->getMembers())->toBeArray();
});

test('canGetChannels', function () use($discord_api) {
    $guild = $discord_api->guild($_ENV['TEST_GUILD_ID']);
    expect($guild->getChannels())->toBeArray();
});

<?php

require 'vendor/autoload.php';

use Asymetricdata\DiscordRestPhp\DiscordApi;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


$discord_api = new DiscordApi(
    token: $_ENV['DISCORD_BOT_TOKEN'],
    api_version: $_ENV['DISCORD_API_VERSION'],
    api_endpoint: $_ENV['DISCORD_API_ENDPOINT'],
);

$guild = $discord_api->guild($_ENV['TEST_GUILD_ID']);

foreach($guild->getMembers() as $member){
   echo $member->user->global_name;
}
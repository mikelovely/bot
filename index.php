<?php

require __DIR__ . '/vendor/autoload.php';

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;

DriverManager::loadDriver(FacebookDriver::class);

try {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();
} catch (\Dotenv\Exception\InvalidPathException $e) {
//
}

$config = [
    // Your driver-specific configuration
    'facebook' => [
        'token' => getenv('FACEBOOK_TOKEN'),
        'app_secret' => getenv('FACEBOOK_APP_SECRET'),
        'verification' => getenv('FACEBOOK_VERIFICATION'),
    ],
];

// create an instance
$botman = BotManFactory::create($config);

// give the bot something to listen for.
$botman->hears('hello', function (BotMan $bot) {
    $bot->reply("Hi my name is George Costanza. I'm unemployed and I live with my parents");
});

$botman->hears('talk to me', function (BotMan $bot) {
    $bot->typesAndWaits(5);
    $bot->reply('What do you want me to say?');
});

$botman->fallback(function (BotMan $bot) {
    $items = [
        "You're giving me the 'It's not you, it's me' routine? I invented 'It's not you, it's me.' Nobody tells me it's them, not me. If it's anybody, it's me.",
        "For I am Costanza...lord of the idiots.",
        "Well, the Jerk Store called, and they're running out of you!",
    ];
    $bot->reply($items[array_rand($items)]);
});

// start listening
$botman->listen();

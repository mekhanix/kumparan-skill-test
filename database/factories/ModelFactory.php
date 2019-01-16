<?php
use App\Domain\News\News;
use App\Domain\Topic\Topic;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});
$factory->define(Topic::class, function ($faker) {
    return [
        'topic_name' => $faker->bs,
        'description' => $faker->catchPhrase,
    ];
});
$factory->define(News::class, function ($faker) {
    return [
        'title' => $faker->catchPhrase,
        'header' => $faker->catchPhrase,
        'content' => $faker->text,
        'status' => $faker->randomElement($array = ['draft', 'deleted', 'publish']),
    ];
});

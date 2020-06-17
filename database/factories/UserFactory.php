<?php

use Faker\Generator as Faker;
use App\Admin\Model\Disease;
use App\Admin\Model\Media;
use App\Admin\Model\Engine;
use App\Admin\Model\Doctor;
use App\Admin\Model\Department;
use App\Admin\Model\Area;



/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Admin\Model\Patient::class, function (Faker $faker) {
    return [
        'name' 				=> $faker->name,
        'sex'  				=> $faker->randomElement(['男', '女']),
        'age'  				=> $faker->numberBetween(18, 80),
        'tel'  				=> $faker->phoneNumber,
        'content'  			=> $faker->text(200),
        'department_id'  	=> $faker->randomElement(Department::where('parent_id', '>', 0)->pluck('id')->toArray()),
        'engine_id'  		=> $faker->randomElement(Engine::pluck('id')->toArray()),
        'keyword' 			=> $faker->word,
        'media_id'  		=> $faker->randomElement(Media::where('parent_id', '>', 0)->pluck('id')->toArray()),
        'area_id'  			=> $faker->numberBetween(1, 3632),
        'admin_user_id'  	=> $faker->numberBetween(1, 5),
        'author_id'  		=> $faker->numberBetween(1, 5),
        'doctor_a_id'  		=> $faker->randomElement(Doctor::where('parent_id', 2)->pluck('id')->toArray()),
        'doctor_b_id'  		=> $faker->randomElement(Doctor::where('parent_id', 1)->pluck('id')->toArray()),
        'come_time'  		=> $faker->dateTimeBetween('now', '2020-12-01', 'PRC'),
        'status'  			=> rand(0, 1)
    ];
});



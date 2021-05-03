<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravel\Models\Assessment;
use App\Laravel\Models\BusinessTransaction;
use App\Laravel\Models\Department;
use Faker\Generator as Faker;

$factory->define(Assessment::class, function (Faker $faker) {
    return [
        'transaction_id' => factory(BusinessTransaction::class),
        'cedula' => $faker->randomDigitNotNull,
        'brgy_fee' => $faker->randomDigitNotNull,
        'bfp_fee' => $faker->randomDigitNotNull,
        'total_assessment' => $faker->randomDigitNotNull,
        'clearance_fee' => $faker->randomDigitNotNull,
        'department_id' => Department::inRandomOrder()->first()->id,
    ];
})->afterCreating(Assessment::class, function (Assessment $assessment, Faker $faker) {
    $assessment->update([
        'total_amount' => $assessment->cedula + $assessment->brgy_fee + $assessment->bfp_fee + $assessment->total_assessment + $assessment->clearance_fee,
    ]);
});

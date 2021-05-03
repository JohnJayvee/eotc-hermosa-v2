<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Models\Customer;
use Faker\Generator as Faker;

$factory->define(ApplicationBusinessPermit::class, function (Faker $faker) {
    return [
        'customer_id' => factory(Customer::class),
        'status' => 'pending',
    ];
});

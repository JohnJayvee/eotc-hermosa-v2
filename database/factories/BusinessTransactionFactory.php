<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessTransaction;
use Faker\Generator as Faker;

$factory->define(BusinessTransaction::class, function (Faker $faker) {
    return [
        'isNew' => 1,
        'business_id' => factory(Business::class),
        'is_resent' => 0,
        'business_permit_id' => factory(ApplicationBusinessPermit::class),
    ];
});

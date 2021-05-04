<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessTransaction;
use App\Laravel\Models\Customer;
use App\Laravel\Models\Department;
use Faker\Generator as Faker;

$factory->define(BusinessTransaction::class, function (Faker $faker) {
    return [
        'owners_id' => factory(Customer::class),
        'isNew' => 1,
        'business_id' => factory(Business::class),
        'business_permit_id' => factory(ApplicationBusinessPermit::class),
        'status' => 'PENDING',
        'is_resent' => 0,
        'is_validated' => 1,
        'department_involved' => json_encode(Department::pluck('code')->all()),
        'for_bplo_approval' => 1,
        'application_name' => $faker->catchPhrase,
    ];
});

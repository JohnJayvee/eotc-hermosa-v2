<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravel\Models\Business;
use App\Laravel\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    return [
        'customer_id' => factory(Customer::class),
        'isNew' => 1,
        'business_scope' => $faker->randomElement(['national', 'regional', 'municipality', 'barangay']),
        'business_type' => $faker->randomElement(['sole_proprietorship', 'cooperative', 'corporation', 'partnership']),
        'business_name' => $faker->company,
        'tradename' => $faker->catchPhrase,
        'dti_sec_cda_registration_no' => $faker->bothify('???###'),
        'dti_sec_cda_registration_date' => $faker->date(),
        'ctc_no' => $faker->bothify('???###'),
        'business_area' => $faker->numberBetween(100, 200),
        'no_of_male_employee' => $faker->numberBetween(1, 5),
        'no_of_female_employee' => $faker->numberBetween(1, 5),
        'male_residing_in_city' => $faker->numberBetween(1, 5),
        'female_residing_in_city' => $faker->numberBetween(1, 5),
        'capitalization' => $faker->randomNumber,
        'has_septic_tank' => $faker->boolean,
        'location' => $faker->city,
    ];
})->afterCreating(Business::class, function (Business $business, Faker $faker) {
    $business->update([
        'email' => $business->owner->email,
        'mobile_no' => $business->owner->contact_number,
    ]);
});

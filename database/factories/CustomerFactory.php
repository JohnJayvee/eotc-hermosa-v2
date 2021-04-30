<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravel\Models\Customer;
use App\Laravel\Models\CustomerFile;
use App\Laravel\Services\ImageUploader;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'mname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->randomElement(['male', 'female']),
        'contact_number' => $faker->bothify('+639#########'),
        'region' => '030000000',
        'region_name' => 'REGION III (CENTRAL LUZON)',
        'town' => '030803000',
        'town_name' => 'BATAAN - CITY OF BALANGA',
        'barangay' => '030803024',
        'barangay_name' => 'BAGONG SILANG',
        'street_name' => $faker->streetName,
        'zipcode' => '2100',
        'birthdate' => $faker->dateTimeThisCentury(),
        'tin_no' => $faker->bothify('???###'),
        'sss_no' => $faker->bothify('???###'),
        'phic_no' => $faker->bothify('???###'),
        'password' => bcrypt('password'),
        'otp_verified' => 1,
        'status' => 'approved',
    ];
})->state(Customer::class, 'pending', function ($faker) {
    return [
        'status' => 'pending',
    ];
})->afterCreating(Customer::class, function (Customer $customer, Faker $faker) {
    $files = [
        'gov_id_1' => UploadedFile::fake()->image('gov-id-1.png'),
        'gov_id_2' => UploadedFile::fake()->image('gov-id-1.png'),
        'business_permit' => UploadedFile::fake()->image('gov-id-1.png'),
    ];

    foreach ($files as $file) {
        $originalName = $file->getClientOriginalName();

        $uploadedImage = ImageUploader::upload($file, 'uploads/customer/file/' . $customer->id);

        CustomerFile::create([
            'path' => $uploadedImage['path'],
            'directory' => $uploadedImage['directory'],
            'filename' => $uploadedImage['filename'],
            'type' => 'image',
            'original_name' => $originalName,
            'application_id' => $customer->id,
        ]);
    }
});

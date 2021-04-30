<?php

use App\Laravel\Models\Customer;
use App\Laravel\Models\CustomerFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::truncate();
        CustomerFile::truncate();

        File::deleteDirectory('public/uploads/customer');

        $customer = factory(Customer::class)->create([
            'email' => 'alice-alpha@mail.com',
            'fname' => 'Alice',
            'mname' => '',
            'lname' => 'Alpha',
        ]);
    }
}

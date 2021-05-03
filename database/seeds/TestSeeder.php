<?php

use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Models\Assessment;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessTransaction;
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
        Business::truncate();
        ApplicationBusinessPermit::truncate();
        BusinessTransaction::truncate();
        Assessment::truncate();

        File::deleteDirectory('public/uploads/customer');

        $customer = factory(Customer::class)->create([
            'email' => 'alice-alpha@mail.com',
            'fname' => 'Alice',
            'mname' => '',
            'lname' => 'Alpha',
        ]);

        $business = factory(Business::class)->create([
            'customer_id' => $customer->id,
        ]);

        $permit = factory(ApplicationBusinessPermit::class)->create([
            'customer_id' => $customer->id,
            'business_id' => $business->id,
        ]);

        $transaction = factory(BusinessTransaction::class)->create([
            'business_id' => $business->id,
            'business_permit_id' => $permit->id,
        ]);

        $assessment = factory(Assessment::class)->create([
            'transaction_id' => $transaction->id,
        ]);
    }
}

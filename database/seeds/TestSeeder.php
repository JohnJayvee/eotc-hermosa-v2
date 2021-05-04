<?php

use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Models\Assessment;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessTransaction;
use App\Laravel\Models\Customer;
use App\Laravel\Models\CustomerFile;
use App\Laravel\Models\Department;
use App\Laravel\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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

        foreach (Department::all() as $department) {
            $name = $department->name . ' Processor';
            $username = Str::slug($name);
            $email = $username . '@mail.com';

            User::firstOrCreate([
                'fname' => $name,
                'status' => 'active',
                'email' => $email,
                'username' => $username,
                'type' => 'processor',
                'password' => bcrypt('password'),
                'department_id' => $department->id,
            ]);
        }

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
            'owners_id' => $customer->id,
            'business_id' => $business->id,
            'business_permit_id' => $permit->id,
        ]);

        $departmentRemarks = [];

        $faker = Factory::create();

        foreach (User::where('type', 'processor')->get() as $user) {
            $remark = [
                'processor_id' => $user->id,
                'id' => $user->department->code,
                'status' => $faker->randomElement(['Approved', 'Declined']),
            ];

            if ('Declined' == $remark['status']) {
                $remark['remarks'] = $faker->catchPhrase;
            }

            array_push($departmentRemarks, $remark);
        }

        $transaction->update([
            'department_remarks' => $departmentRemarks,
        ]);

        $assessment = factory(Assessment::class, 3)->create([
            'transaction_id' => $transaction->id,
        ]);
    }
}

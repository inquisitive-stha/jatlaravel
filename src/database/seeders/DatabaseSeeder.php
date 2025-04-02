<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Company\Models\Company;
use Modules\JobApplication\Models\JobApplication;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $primaryUser = User::factory()->create([
            'name'  => 'Saroj Shrestha',
            'email' => 'thesarojstha@gmail.com',
        ]);
        $users = User::factory(9)->create();
        $users->push($primaryUser);

        //companies
        $companies = Company::factory(10)->create([
            'user_id' => $users->random()->id,
        ]);

        //job applications
        JobApplication::factory(10)->create([
            'user_id'    => $users->random()->id,
            'company_id' => $companies->random()->id,
        ]);
    }
}

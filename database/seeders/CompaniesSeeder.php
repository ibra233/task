<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\IndustryOfCompanies;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Companies::factory()->count(5)->create()->each(function ($company) {
            IndustryOfCompanies::factory(rand(1, 4))->create([
                'company_id' => $company->id,
            ]);
        });
    }
}

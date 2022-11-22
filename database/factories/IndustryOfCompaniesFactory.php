<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Industries;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IndustryOfCompanies>
 */
class IndustryOfCompaniesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ids = Industries::pluck('id');
        return [
            'industry_id' => $this->faker->randomElement($ids)
        ];
    }
}

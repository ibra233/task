<?php

namespace Database\Factories;

use App\Models\Industries;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'industry_id' => $this->faker->randomElement($ids),
        ];
    }
}

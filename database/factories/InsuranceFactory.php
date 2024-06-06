<?php

namespace Database\Factories;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Patient;

class InsuranceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Insurance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $patient = Patient::first();
        if (!$patient) {
            $patient = Patient::factory()->create();
        }

        return [
            'patient_id' => $this->faker->word,
            'provider_name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'policy_number' => $this->faker->text($this->faker->numberBetween(5, 50)),
            'coverage_details' => $this->faker->text($this->faker->numberBetween(5, 65535))
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\HealthMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Patient;

class HealthMetricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HealthMetric::class;

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
            'metric_type' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'value' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'measurement_date' => $this->faker->date('Y-m-d'),
            'created_by' => $this->faker->word
        ];
    }
}

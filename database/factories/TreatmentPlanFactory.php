<?php

namespace Database\Factories;

use App\Models\TreatmentPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Doctor;
use App\Models\Patient;

class TreatmentPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TreatmentPlan::class;

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
            'doctor_id' => $this->faker->word,
            'description' => $this->faker->text($this->faker->numberBetween(5, 65535)),
            'start_date' => $this->faker->date('Y-m-d'),
            'end_date' => $this->faker->date('Y-m-d'),
            'created_by' => $this->faker->word
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Doctor;
use App\Models\User;

class PrescriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prescription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'doctor_id' => $this->faker->word,
            'patient_id' => $this->faker->word,
            'date_issued' => $this->faker->date('Y-m-d'),
            'created_by' => $this->faker->word
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Doctor;
use App\Models\User;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

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
            'appointment_date' => $this->faker->date('Y-m-d H:i:s'),
            'created_by' => $this->faker->word,
            'status' => $this->faker->word
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Appointment;

class ConsultationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consultation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $appointment = Appointment::first();
        if (!$appointment) {
            $appointment = Appointment::factory()->create();
        }

        return [
            'appointment_id' => $this->faker->word,
            'notes' => $this->faker->text($this->faker->numberBetween(5, 65535)),
            'created_by' => $this->faker->word,
            'consultation_date' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

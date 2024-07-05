<?php

namespace Database\Factories;

use App\Models\FacilityAppointment;
use Illuminate\Database\Eloquent\Factories\Factory;


class FacilityAppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FacilityAppointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'patient_record' => $this->faker->numberBetween(0, 999),
            'appointment_date' => $this->faker->word,
            'appointment_time' => $this->faker->date('H:i:s'),
            'facility_id' => $this->faker->numberBetween(0, 999),
            'appointment_status' => $this->faker->numberBetween(0, 999),
            'results' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'documents_url' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

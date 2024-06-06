<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Patient;
use App\Models\Doctor;

class MedicalRecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedicalRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $doctor = Doctor::first();
        if (!$doctor) {
            $doctor = Doctor::factory()->create();
        }

        return [
            'patient_id' => $this->faker->word,
            'doctor_id' => $this->faker->word,
            'created_by' => $this->faker->word,
            'record_type' => $this->faker->word,
            'description' => $this->faker->text($this->faker->numberBetween(5, 65535)),
            'date_created' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

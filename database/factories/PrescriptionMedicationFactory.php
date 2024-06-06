<?php

namespace Database\Factories;

use App\Models\PrescriptionMedication;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Medication;
use App\Models\Prescription;

class PrescriptionMedicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrescriptionMedication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $prescription = Prescription::first();
        if (!$prescription) {
            $prescription = Prescription::factory()->create();
        }

        return [
            'prescription_id' => $this->faker->word,
            'medication_id' => $this->faker->word,
            'dosage' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'frequency' => $this->faker->text($this->faker->numberBetween(5, 100))
        ];
    }
}

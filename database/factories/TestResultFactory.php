<?php

namespace Database\Factories;

use App\Models\TestResult;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\MedicalRecord;

class TestResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TestResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $medicalRecord = MedicalRecord::first();
        if (!$medicalRecord) {
            $medicalRecord = MedicalRecord::factory()->create();
        }

        return [
            'record_id' => $this->faker->word,
            'test_name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'result' => $this->faker->text($this->faker->numberBetween(5, 65535)),
            'date_performed' => $this->faker->date('Y-m-d'),
            'created_by' => $this->faker->word
        ];
    }
}

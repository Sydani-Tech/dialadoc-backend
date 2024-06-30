<?php

namespace Database\Factories;

use App\Models\PatientRecord;
use Illuminate\Database\Eloquent\Factories\Factory;


class PatientRecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PatientRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'update_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'suspected_illness' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'findings' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'recommended_tests' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'recommended_facility' => $this->faker->numberBetween(0, 999),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

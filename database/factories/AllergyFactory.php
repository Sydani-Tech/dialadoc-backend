<?php

namespace Database\Factories;

use App\Models\Allergy;
use Illuminate\Database\Eloquent\Factories\Factory;


class AllergyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Allergy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'value' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'patient_id' => $this->faker->numberBetween(0, 999),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

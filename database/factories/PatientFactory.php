<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Location;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $location = Location::first();
        if (!$location) {
            $location = Location::factory()->create();
        }

        return [
            'user_id' => $this->faker->word,
            'date_of_birth' => $this->faker->date('Y-m-d'),
            'gender' => $this->faker->word,
            'blood_group' => $this->faker->text($this->faker->numberBetween(5, 10)),
            'genotype' => $this->faker->text($this->faker->numberBetween(5, 10)),
            'location_id' => $this->faker->word
        ];
    }
}

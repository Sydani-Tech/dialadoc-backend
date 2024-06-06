<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;


class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'city' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'state' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'country' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'postal_code' => $this->faker->text($this->faker->numberBetween(5, 20))
        ];
    }
}

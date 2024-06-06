<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Location;

class PharmacyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pharmacy::class;

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
            'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'location_id' => $this->faker->word
        ];
    }
}

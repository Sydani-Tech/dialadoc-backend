<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Specialization;
use App\Models\Location;
use App\Models\User;

class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        return [
            'user_id' => $this->faker->word,
            'specialization_id' => $this->faker->word,
            'location_id' => $this->faker->word,
            'experience_years' => $this->faker->word,
            'mdcn_license' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'cpd_annual_license' => $this->faker->text($this->faker->numberBetween(5, 100)),
            'bank_details' => $this->faker->text($this->faker->numberBetween(5, 255))
        ];
    }
}

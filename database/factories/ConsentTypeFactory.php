<?php

namespace Database\Factories;

use App\Models\ConsentType;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Doctor;
use App\Models\User;

class ConsentTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConsentType::class;

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
            'doctor_id' => $this->faker->word,
            'consent_type' => $this->faker->word,
            'granted' => $this->faker->boolean,
            'consent_date' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

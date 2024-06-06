<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Doctor;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

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
            'doctor_id' => $this->faker->word,
            'patient_id' => $this->faker->word,
            'rating' => $this->faker->word,
            'review_text' => $this->faker->text($this->faker->numberBetween(5, 65535)),
            'review_date' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

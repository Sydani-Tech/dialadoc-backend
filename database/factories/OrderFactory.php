<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Prescription;
use App\Models\Pharmacy;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $pharmacy = Pharmacy::first();
        if (!$pharmacy) {
            $pharmacy = Pharmacy::factory()->create();
        }

        return [
            'prescription_id' => $this->faker->word,
            'pharmacy_id' => $this->faker->word,
            'consultation_id' => $this->faker->word,
            'user_id' => $this->faker->word,
            'order_date' => $this->faker->date('Y-m-d H:i:s'),
            'order_type' => $this->faker->word,
            'status' => $this->faker->word
        ];
    }
}

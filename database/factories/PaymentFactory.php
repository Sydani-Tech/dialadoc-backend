<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Order;
use App\Models\User;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

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
            'order_id' => $this->faker->word,
            'amount' => $this->faker->numberBetween(0, 9223372036854775807),
            'currency' => $this->faker->text($this->faker->numberBetween(5, 10)),
            'payment_date' => $this->faker->date('Y-m-d H:i:s'),
            'status' => $this->faker->word
        ];
    }
}

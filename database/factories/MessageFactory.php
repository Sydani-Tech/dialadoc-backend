<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Consultation;
use App\Models\User;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

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
            'consultation_id' => $this->faker->word,
            'sender_id' => $this->faker->word,
            'receiver_id' => $this->faker->word,
            'message_text' => $this->faker->text($this->faker->numberBetween(5, 65535)),
            'sent_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

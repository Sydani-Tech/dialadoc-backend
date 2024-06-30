<?php

namespace Database\Factories;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;


class FacilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Facility::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'logo_url' => $this->faker->text($this->faker->numberBetween(5, 255)),
            'facility_name' => $this->faker->firstName,
            'role_in_facility' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'country' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'state' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'lga' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'working_hours' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'helpdesk_email' => $this->faker->email,
            'helpdesk_number' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'number_of_staff' => $this->faker->numberBetween(0, 999),
            'year_of_inception' => $this->faker->date('Y-m-d'),
            'facility_type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'cac_number' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'user_id' => $this->faker->numberBetween(0, 999),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}

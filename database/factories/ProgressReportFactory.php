<?php

namespace Database\Factories;

use App\Models\ProgressReport;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\TreatmentPlan;

class ProgressReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProgressReport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $treatmentPlan = TreatmentPlan::first();
        if (!$treatmentPlan) {
            $treatmentPlan = TreatmentPlan::factory()->create();
        }

        return [
            'plan_id' => $this->faker->word,
            'created_by' => $this->faker->word,
            'report_date' => $this->faker->date('Y-m-d'),
            'progress_description' => $this->faker->text($this->faker->numberBetween(5, 65535))
        ];
    }
}

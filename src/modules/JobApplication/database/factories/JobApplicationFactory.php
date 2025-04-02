<?php

namespace Modules\JobApplication\database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Company\Models\Company;
use Modules\JobApplication\Constants\JobApplicationStatusConstant;
use Modules\JobApplication\Models\JobApplication;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobApplicationFactory extends Factory
{
    protected $model = JobApplication::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_title' => $this->faker->jobTitle,
            'job_post_url' => $this->faker->url,
            'user_id' => User::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
            'status' => $this->faker->randomElement(JobApplicationStatusConstant::getKeys()),
        ];
    }
}

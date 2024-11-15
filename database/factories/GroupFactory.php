<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(),
            'course_id' => Course::inRandomOrder()->first()->id,
        ];
    }
}

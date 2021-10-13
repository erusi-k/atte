<?php

namespace Database\Factories;

use App\Models\BreakTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class BreakTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BreakTime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>$this->faker->numberBetween(1,30),
            'day'=>$this->faker->dateTimeBetween($startDate = 'now',$endDate='+3 week'),
            'breakIn'=>$this->faker->time,
            'breakOut'=>$this->faker->time
        ];
    }
}

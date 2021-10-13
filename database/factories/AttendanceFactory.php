<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

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
            'punchIn'=>$this->faker->time,
            'punchOut'=>$this->faker->time,
        ];
    }
}

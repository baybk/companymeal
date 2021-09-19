<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'team_id' => 1,
            'customer_name' => $this->faker->name(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_address' => $this->faker->address(),
            'customer_email' => $this->faker->email(),
            'payment_status' => PAYMENT_STATUS_WAITING,
            'delivery_status' => DELIVERY_STATUS_REQUEST,
            'general_note' => $this->faker->text(80),
            'lines' => [
                [
                    'productId' => random_int(1, 3),
                    'productName' => $this->faker->name(),
                    'quantity' => random_int(1, 50),
                    'price' => random_int(10000, 1000000),
                    'note' => $this->faker->text(80),
                    'thumbnail' => $this->faker->image()
                ],
                // [
                //     'productId' => random_int(1, 3),
                //     'productName' => $this->faker->name(),
                //     'quantity' => random_int(1, 50),
                //     'price' => random_int(10000, 1000000),
                //     'note' => $this->faker->text(80),
                //     'thumbnail' => $this->faker->image()
                // ]
            ]
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    
    //protected $model = Customer::class;

    public function definition(): array
    {

        // Generate a random "type of business" for the customer
        $type = $this->faker->randomElement(['individual', 'business']);
        // Generate a random name for the customer
        $name = $type === 'individual' ? $this->faker->name() : $this->faker->company();
        
        return [
            'name' => $name,
            'type' => $type,
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode()
        ];
    }
}

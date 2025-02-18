<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define randon fake data for status column
        $status = $this->faker->randomElement(['billed', 'paid', 'void']);

        return [
            'customer_id' => Customer::factory(), // customer_id comes from customer factory because its the foreign key
            'amount' => $this->faker->numberBetween(100, 20000), // not 0 and not negative
            'status' => $status,
            'billed_date' => $this->faker->dateTimeThisDecade(),
            // If status is paid then create a random date for paid_date column otherwise set it to null
            'paid_date' => $status === 'paid' ? $this->faker->dateTimeThisDecade() : NULL
            // Ignore timestamps and table id as it is auto generated/incremented
        ];
    }
}

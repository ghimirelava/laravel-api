<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// PHP class that allows you to populate the database with test data
class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    // Creating 230 customers each with diffrent number of invoices
    public function run(): void
    {
        // 25 customers with 10 invoices each
        Customer::factory()
            ->count(25)
            ->hasInvoices(10)
            ->create();
        
        // 100 customers with 10 invoices each
        Customer::factory()
            ->count(100)
            ->hasInvoices(10)
            ->create();

        // 100 customers with 3 invoices each
        Customer::factory()
            ->count(100)
            ->hasInvoices(3)
            ->create();
        
        // 5 customers with no invoices
        Customer::factory()
            ->count(5)
            ->create();
            
    }
}

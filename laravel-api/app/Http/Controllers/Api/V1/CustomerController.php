<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use App\Filters\V1\CustomersFilter;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter(); 
        $filterItems = $filter->transform($request); //[[column, operator, value], [column, operator, value], ...]
        
        $includeInvoices = $request->query('includeInvoices');

        //when querying with eloquent and you pass an empty array in where(), there is nothing to paignate
        //so its like you arent calling where at all so we can remove the if else block
        //if you have no filters, return all customers. otherwise, return the filtered customers
        $customers = Customer::where($filterItems);
        
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //return $customer; // Can return a specific customer ex. localhost:8000/api/v1/customers/1
        return new CustomerResource($customer); // Can return a specific customer with limited database columns ex. localhost:8000/api/v1/customers/1
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Resources\V1\InvoiceCollection;
use App\Filters\V1\InvoicesFilter;
use Illuminate\Support\Arr;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoicesFilter(); // should you new up the construtor here or create a facde for the filter?
        $filterItems = $filter->transform($request); //[[column, operator, value], [column, operator, value], ...]
        
        // if you have no filters, return all invoices. otherwise, return the filtered invoices
        if (count($filterItems) == 0) {
            return new InvoiceCollection(Invoice::paginate()); // Can return all customers
        }else{
            $invoices = Invoice::where($filterItems)->paginate();
            return new InvoiceCollection($invoices->append($request->query())); 
        }
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
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Store a bulk of newly created resource in storage.
     */
    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        // Bulk store invoices
        $bulk = collect($request->all())->map(function($arr, $key) {
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']); //removing customerId, billedId, and paidDate from the array
        });

        Invoice::insert($bulk->toArray()); //inserting the bulk data into the database
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}

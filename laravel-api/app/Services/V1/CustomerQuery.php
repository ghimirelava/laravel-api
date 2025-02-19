<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class CustomerQuery {

    //define the columns that are safe to query against
    protected $safeParams = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    //transform the columns from the query string to the columns in the database
    protected $columnMap = [
        'postalCode'=>'postal_code'
    ];

    //transform the operators from the query string to the operators that eloquent understands
    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'gte' => '>=',
        'lt' => '<',
        'lte' => '<=',
    ];

    //transform the request query string into an array we can pass onto eloquent
    public function transform(Request $request): array
    {
        //initialize the eloquent query
        $eloQuery = [];

        //loop through the safe parameters
        foreach ($this->safeParams as $parm => $operators) {
            
            $query = $request->query($parm); //get the query string for the parameter

            //if the query string is not set, skip to the next parameter
            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm; //get the column name from the map or use the parameter name

            //loop through the operators and add the query to the eloquent query
            foreach ($operators as $operator) {
                if (isset($query[$operator])) { //if the operator is set in the query string
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]]; //add the query to the eloquent query
                }
            }
        }

        return $eloQuery;
    }






    /*public function transform(Request $request): array
    {
        $queryItems = [];
        $columns = ['id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at'];

        foreach ($columns as $column) {
            if ($request->has($column)) {
                $queryItems[] = [$column, '=', $request->input($column)];
            }
        }

        return $queryItems;
    }*/
}
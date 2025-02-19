<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoicesFilter extends ApiFilter{

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
}
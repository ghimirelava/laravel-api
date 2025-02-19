<?php

namespace App\Filters;

use Illuminate\Http\Request;

//abstract class to filter the query string
//ideally this will not be versioned
class ApiFilter{

    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [];

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
<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 07.11.2018
 * Time: 1:49
 */

namespace App\Http\Filters;
use App\Http\Filters\Interfaces\FilterInterface;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;

class TransactionFilterIndex
{
    const FILTER_NOT_FOUND = "Requested filter not found\n";


    //List of available filters
    protected $filters = [
        'income'  => FilterTransactionByIncome::class,
        'expense' => FilterTransactionByExpense::class,
        'amount'  => FilterTransactionByAmount::class,
        'date'    => FilterTransactionByCreatedDate::class
    ];


    protected $requestedFilters = [];

    protected $filtered;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    //Parse the request to get the list of requested filters
    public function parseRequest() : bool
    {
        $this->requestedFilters = (array)($this->request->only(array_keys($this->filters)));
        if(empty($this->requestedFilters)){
            return false;
        }else{
            return true;
        }
    }


    public function activateFilters($collection){
        $this->filtered = $collection;

        //Check if there is any known requested filter
        if($this->parseRequest()){

            //if yes run the filters one by one and send the filtered value to the next filter
            foreach ($this->requestedFilters as $filter => $val){
                $this->filtered = $this->runFilter($this->getFilter($filter), $this->filtered, $val);

                //If error occured in one of the filters it will return false
                //Otherwise it returns the instance of Collection class
                //Here we check for the errors
                if(!is_a($this->filtered, Builder::class)){
                    return (string) false;
                    break;
                }
            }
//                return $this->requestedFilters;
            return TransactionResource::collection($this->filtered->get());
        }else{

            return self::FILTER_NOT_FOUND;
        }
    }

    private function getFilter($key){
        return new $this->filters[$key];
    }

    private function runFilter(FilterInterface $filter, Builder $collection, $val){
        return $filter->filter($collection, $val);
    }



}
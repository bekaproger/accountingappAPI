<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 09.11.2018
 * Time: 1:48
 */

namespace App\Http\Filters;

use App\Http\Filters\Interfaces\FilterInterface;


class FilterTransactionByAmount implements FilterInterface
{

    protected $transactions;

    public function __construct()
    {

    }

    public function filter($collection, $val)
    {
        $this->transactions = $collection->where('amount', $val);

        return $this->transactions;

    }
}
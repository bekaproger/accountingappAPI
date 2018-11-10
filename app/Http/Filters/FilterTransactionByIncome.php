<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 07.11.2018
 * Time: 1:46
 */

namespace App\Http\Filters;
use App\Http\Filters\Interfaces\FilterInterface;


class FilterTransactionByIncome implements FilterInterface
{

    protected $transactions;

    public function filter($collection, $val)
    {
        //IF VAL IS NOT NEEDED WE JUST GIVE IT A NULL VALUE
        $val = null;
        $this->transactions = $collection->where('amount', '>', 0)->orderBy('amount');

        return $this->transactions;
    }
}
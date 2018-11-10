<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 08.11.2018
 * Time: 18:18
 */

namespace App\Http\Filters;
use App\Http\Filters\Interfaces\FilterInterface;


class FilterTransactionByExpense implements FilterInterface
{
    protected $transactions;

    public function filter($collection, $val)
    {
        //IF VAL IS NOT NEEDED WE JUST GIVE IT A NULL VALUE
        $val = null;
        $this->transactions = $collection->where('amount', '<', '0')->orderBy('amount');

        return $this->transactions;
    }


}
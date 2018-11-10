<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 09.11.2018
 * Time: 2:25
 */

namespace App\Http\Filters;

use App\Http\Filters\Interfaces\FilterInterface;

class FilterTransactionByCreatedDate implements  FilterInterface
{

    protected $transactions;

    protected $pattern = '/\d{4}-\d{2}-\d{2}/';

    public function filter($collection, $val)
    {
        $this->transactions = $collection->whereDate('created_at', $val );

        return $this->transactions;
    }

}
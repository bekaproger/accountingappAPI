<?php
/**
 * Created by PhpStorm.
 * User: Bekzod
 * Date: 07.11.2018
 * Time: 1:39
 */

namespace App\Http\Filters\Interfaces;

use Illuminate\Database\Query\Builder ;

interface FilterInterface
{
    const Valid = 11;

    public function filter(Builder $collection, $val);
}
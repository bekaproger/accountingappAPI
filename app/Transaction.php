<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\TransactionFilterIndex;
use Illuminate\Database\Query\Builder;


class Transaction extends Model
{


    protected $fillable = [
        'author_id', 'amount', 'title'
    ];

    public function transactionUser()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    public function isExpense()
    {
        return $this->type  == 'expense' ?  true  :  false;
    }

    public function isIncome()
    {
        return $this->type == 'income' ?  true : false;
    }

    public function runFilter(Builder $collection, $request)
    {
        return (new TransactionFilterIndex($request))->activateFilters($collection);
    }

    public function transactionExists($id)
    {
        $transaction = self::find($id);
        return !is_null($transaction) ? $transaction : false;
    }

}

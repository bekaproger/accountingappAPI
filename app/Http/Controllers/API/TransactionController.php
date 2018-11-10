<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource as TrResource;
use App\Http\Requests\TransactionValidation;
use App\Http\Filters\TransactionFilterIndex;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidateFilterInputRequest as Validate;
use App\User;
use Auth;


class TransactionController extends Controller
{

    protected const BALANCE_IS_NULL = "Your balance is 0\n";
    protected const TRANSACTION_NOT_FOUND = "Transaction not found\n";
    protected $transaction;
    protected $filter;
    protected $user;
    
    public function __construct(Transaction $transaction, TransactionFilterIndex $filter, User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->transaction = $transaction;
        $this->filter = $filter;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TrResource::collection($request->user()->userTransactions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionValidation $request)
    {
        if($this->expenseAvailable($request)){
            $transaction = $this->transaction->create([
                'amount'    => $request->amount,
                'title'     => $request->title,
                'author_id' => $request->user()->id
            ]);

            return new TrResource($transaction);

        }else{
            return self::BALANCE_IS_NULL;
        }
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->transaction->transactionExists($id);
        if($transaction){
            return new TrResource($transaction);
        }else{
            return self::TRANSACTION_NOT_FOUND;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionValidation $request, $id)
    {
        $transaction = $this->transaction->transactionExists($id);
        if($transaction){
            if($this->expenseAvailable($request)){
                $transaction->update([
                    'amount' => $request->amount,
                    'title' => $request->title
                ]);
                return new TrResource($transaction);
            }else{
                return self::BALANCE_IS_NULL;
            }
        }else{
            return self::TRANSACTION_NOT_FOUND;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = $this->transaction->transactionExists($id);

        if(!$transaction){
            return self::TRANSACTION_NOT_FOUND;
        }
        $transaction->delete();

        return response('Transaction deleted', 200)
            ->header('Content-Type', 'text/plain');
    }

    public function filter(Validate $request)
    {
        $transactions = DB::table('transactions')->where('author_id', $request->user()->id);
        return $this->transaction->runFilter($transactions, $request);
    }

    public function balance()
    {
        return Auth::user()->userTransactions->sum('amount');
    }

    public function expenseAvailable(TransactionValidation $request) : bool
    {
        return $this->balance() + (integer) $request->amount >= 0;
    }


}

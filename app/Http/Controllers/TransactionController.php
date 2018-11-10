<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Auth;

class TransactionController extends Controller
{
    public function index(){
        return view('transactions', ['transactions' => Auth::user()->userTransactions]);
    }
}

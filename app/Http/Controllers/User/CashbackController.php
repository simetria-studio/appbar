<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    public function index(){
        return view('front.cashback.index');
    }
}

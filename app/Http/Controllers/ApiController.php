<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\ArzRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    private $arz;

    /**
     * dependency injection arzRepository (repository pattern)
     */
    public function __construct(ArzRepository $arzRepository)
    {
        $this->arz = $arzRepository;
    }

    /**
     * authentication user with email and password
     * generate api_key for per user
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(Str::random(40));
            User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
            return response()->json(['status' => 'success','api_key' => $apikey]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    /**
     * create deposit transaction with call the method
     */
    public function deposit(Request $request)
    {
        $this->validate($request, [
            'price' => 'required'
        ]);

        $this->arz->deposit($request->price);

        return response()->json([
            'message' => 'Deposit successfully Created',
        ], 201);
    }

    /**
     * create withdraw transaction with call the method
     */
    public function withdraw(Request $request)
    {
        $this->validate($request, [
            'price' => 'required'
        ]);

        $this->arz->withdraw($request->price);

        return response()->json([
            'message' => 'Withdraw successfully Created',
        ], 201);
    }

    /**
     * get wallet user with call the method
     */
    public function showStock()
    {
        $wallet = $this->arz->showStock();

        return response()->json([
            'message' => 'your wallet is ' . $wallet,
        ], 200);
    }

    /**
     * get transaction list user with call the method
     */
    public function transactionList()
    {
        $transactions = $this->arz->transactionList();

        return response()->json([
            'transactions' => $transactions
        ], 200);
    }
}

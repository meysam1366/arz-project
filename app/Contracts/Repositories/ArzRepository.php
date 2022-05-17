<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ArzInterface;

class ArzRepository implements ArzInterface
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * create deposit
     */
    public function deposit($price)
    {
        $transaction = $this->user->transactions()->create([
            'price' => $price,
            'action' => 'deposit'
        ]);

        $this->user->increment('wallet', $price);

        return $transaction;
    }

    /**
     * create withdraw
     */
    public function withdraw($price)
    {
        $transaction = $this->user->transactions()->create([
            'price' => $price,
            'action' => 'withdraw'
        ]);

        if($this->showStock() != 0) {
            $this->user->decrement('wallet', $price);
        }

        return $transaction;
    }

    /**
     * get wallet user
     */
    public function showStock()
    {
        return $this->user->wallet;
    }

    /**
     * get transaction list
     */
    public function transactionList()
    {
        return $this->user->transactions;
    }
}

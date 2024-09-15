<?php

namespace App\Http\Controllers\Account;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $account = Auth::user()->account;
        return view('account.home', compact('account'));
    }

    public function  depositView()
    {
        return view('account.deposit');
    }
    public function  withdrawView()
    {
        return view('account.withdraw');
    }

    public function transferView()
    {
        return view('account.transfer');
    }

    public function deposit(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $account = Auth::user()->account;

        // Save the current balance before deposit
        $before_balance = $account->balance;

        // Add the deposit amount to the account balance
        $account->balance += $request->amount;
        $account->save();

        // Create a transaction record with type 'credit'
        Transaction::create([
            'receiver_account_id' => $account->id,
            'amount' => $request->amount,
            'before_balance' => $before_balance,
            'after_balance' => $account->balance,
            'type' => 'credit',  // Mark the transaction as a credit
        ]);

        flash()->success('Deposit successful.');

        return redirect()->route('deposit.view');
    }


    public function withdraw(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
        $account = Auth::user()->account;

        // Check if the account has sufficient balance for the withdrawal
        if ($account->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance');
        }

        // Save the before balance
        $before_balance = $account->balance;

        // Deduct the withdrawal amount from the account balance
        $account->balance -= $request->amount;
        $account->save();

        // Create a transaction record with type 'debit'
        Transaction::create([
            'sender_account_id' => $account->id,
            'amount' => $request->amount,
            'before_balance' => $before_balance,
            'after_balance' => $account->balance,
            'type' => 'debit',  // Mark the transaction as a debit
        ]);

        flash()->success('Withdraw successful.');

        return redirect()->route('withdraw.view');
    }


    public function transfer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:1',
        ]);

        $sender = Auth::user()->account;
        $receiver = Account::whereHas('user', fn($q) => $q->where('email', $request->email))->first();

        if ($sender->balance < $request->amount) {
            return redirect()->back()->with('error', 'Insufficient balance');
        }

        // Process sender (Debit)
        $before_balance = $sender->balance;
        $sender->balance -= $request->amount;
        $sender->save();

        Transaction::create([
            'sender_account_id' => $sender->id,
            'receiver_account_id' => $receiver->id,
            'amount' => $request->amount,
            'before_balance' => $before_balance,
            'after_balance' => $sender->balance,
            'type' => 'debit', // Debit for sender
        ]);

        // Process receiver (Credit)
        $receiver_before_balance = $receiver->balance;
        $receiver->balance += $request->amount;
        $receiver->save();

        Transaction::create([
            'sender_account_id' => $sender->id,
            'receiver_account_id' => $receiver->id,
            'amount' => $request->amount,
            'before_balance' => $receiver_before_balance,
            'after_balance' => $receiver->balance,
            'type' => 'credit', // Credit for receiver
        ]);

        flash()->success('Transfer successful.');

        return redirect()->route('transfer.view');
    }


    public function statement()
    {
        $account = Auth::user()->account;
        $transactions = Transaction::where('sender_account_id', $account->id)
            ->orWhere('receiver_account_id', $account->id)
            ->get();

        return view('account.statement', compact('transactions'));
    }
}

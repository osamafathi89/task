<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Client;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->level_id == 'client') {
            $transactions = \DB::select('select * from transactions_users where effected = ?', [Auth::user()->id]);
            $total = \DB::select('select sum(amount) as total from transactions_users where effected = ?', [Auth::user()->id]);
            return view('client.operation', compact('transactions', 'total'));
        } else if (Auth::user()->level_id == 'user') {
            $transactions = \DB::select('select * from transactions_users where doner = ?', [Auth::user()->id]);
            $total = \DB::select('select sum(amount) as total from transactions_users where doner = ?', [Auth::user()->id]);
            return view('user.operation', compact('transactions', 'total'));

        }else if(Auth::user()->level_id=='admin'){
            $transactions = \DB::select('select * from transactions_run');
            // dd($transactions);
            $total = \DB::select('select sum(amount) as total from transactions_users where doner = ?', [Auth::user()->id]);
            $users = \DB::select('select * from users where level_id = ?', ['client']);
            return view('admin.operation', compact('transactions', 'users','total'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->level_id == 'client') {
            return view('client.buy');
        } elseif (Auth::user()->level_id == 'user') {
            $users = \DB::select('select * from users where level_id = ?', ['client']);
            return view('user.buy', compact('users'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        $store = new Transaction();
        if (Auth::user()->level_id == 'client') {
            $store->doner = Auth::user()->id;
            $store->effected = Auth::user()->id;
            $store->reciever = Auth::user()->id;
            $store->amount = $request->amount;
            $store->process = "withdraw";
            $store->save();
            $this->clientData($store);
            return redirect()->route('transaction.index');
        } else if (Auth::user()->level_id == 'user') {
            $store->doner = Auth::user()->id;
            $store->effected = $request->effected;
            $store->amount = $request->amount;
            $store->reciever = $request->reciever;
            $store->process = $request->process;
            $store->save();
            $this->clientData($store);
            return redirect()->route('transaction.index');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
    public function clientData($data)
    {

        $client = new Client();
        switch ($data->process) {
            case 'withdraw':
                $client->withDraw($data);
                break;
            case 'transfer':
                $client->transfer($data);
                break;
            case 'charge':
                $client->charge($data);
                break;
            default:
                # code...
                break;
        }
    }
public function filterTrans(StoreTransactionRequest $request){
    $transactions = \DB::select('select * from transactions_run where client_id='.$request->id);
    // dd($transactions);
    $id = $request->id;
    $total = \DB::select('select sum(amount) as total from transactions_users where reciever = ?', [$request->id]);
    $users = \DB::select('select * from users where level_id = ?', ['client']);
    return view('admin.operation', compact('transactions', 'users','total','id'));
}
}

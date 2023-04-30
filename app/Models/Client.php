<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public function withDraw($data){
        $total  = \DB::select("select amount from clients where client_id = $data->effected order by id DESC");
        $this->trans_id=$data->id;
        $this->client_id=$data->effected;
        $this->amount=isset($total[0]->amount)?($total[0]->amount-$data->amount):(-1*$data->amount);
        $this->user_id=\Auth::user()->id;
        $this->main_id=$data->effected;
        $this->save();

    }
    public function transfer($data){
        $update_at = time();
        $created_at = time();
        $total1  = \DB::select("select amount from clients where client_id = $data->effected order by id DESC");
        $trans1['trans_id']=$data->id;
        $trans1['client_id']=$data->effected;
        $trans1['amount']=isset($total1[0]->amount)?($total1[0]->amount-$data->amount):(-1*$data->amount);
        $trans1['user_id']=\Auth::user()->id;
        $trans1['main_id']=$data->reciever;

        $total2  = \DB::select("select amount from clients where client_id = $data->reciever order by id DESC");
        $trans2['trans_id']=$data->id;
        $trans2['client_id']=$data->reciever;
        $trans2['amount']=-isset($total2[0]->amount)?($total2[0]->amount+$data->amount):($data->amount);
        $trans2['user_id']=\Auth::user()->id;
        $trans2['main_id']=$data->effected;
        $sql = "INSERT INTO `clients`( `trans_id`, `client_id`, `amount`, `user_id`, `main_id`) VALUES(
        '{$trans1['trans_id']}',
        '{$trans1['client_id']}',
        '{$trans1['amount']}',
        '{$trans1['user_id']}',
        '{$trans1['main_id']}'
        ),
        (
        '{$trans2['trans_id']}',
        '{$trans2['client_id']}',
        '{$trans2['amount']}',
        '{$trans2['user_id']}',
        '{$trans2['main_id']}'
        )";
    \DB::insert($sql);

    }
    public function charge($data){
        $total  = \DB::select("select amount from clients where client_id = $data->reciever order by id DESC");
        $this->trans_id=$data->id;
        $this->client_id=$data->reciever;
        $this->amount=isset($total[0]->amount)?($total[0]->amount+$data->amount):($data->amount);
        $this->user_id=\Auth::user()->id;
        $this->main_id=\Auth::user()->id;
        $this->save();
    }


}

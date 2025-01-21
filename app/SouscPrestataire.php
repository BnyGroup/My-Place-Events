<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SouscPrestataire extends Model
{
    //
    protected $table='sousc_prestataires';
    protected $fillable=['id_prestataire','id_frontuser','formule','montant','status','payment_gateway','payment_id','payment_amount','payment_method','payment_phone_prefixe',
        'payment_phone_number','payment_ipn_ack','payment_trans_status','payment_designation','payment_buyer_name','payment_date','payment_expire','id_transaction'];

    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

    public function getDataById($id)
    {
        return static::where('id_prestataire',$id)
            ->where('status', 1)
            ->get();
    }

    public function getDataByIdTransaction($id)
    {
        return static::where('id_transaction',$id)
            ->first();
    }

    public function getPaymentState($id){
        return static::where('id_prestataire',$id)
            ->latest()
            ->first();
    }

    public function getLatestData($id){
        return static::where('id_prestataire',$id)
            ->latest()
            ->first();
    }

    public function getLatestDataByFrontId($id){
        return static::where('id_frontuser',$id)
            ->latest()
            ->first();
    }

    public function updateLastData($id,$input) {
        return static::where('id_prestataire',$id)
            ->latest()
            ->first()
            ->update(array_only($input,$this->fillable));
    }

    public function deleteLastUpdate($id){
        $data = static::where('id_frontuser',$id)
            ->latest()
            ->first();
        return $data->delete();
    }

    public function deletePayment($id){
        $data = static::where('id_transaction',$id)
            ->first();
        return $data->delete();
    }

    public function getData()
    {
        return static::get();
    }

    public function count_sousc_number($id_prest){
        return $count = static::where('id_prestataire',$id_prest)->count();
    }

    public function no_repeat_payment($id_transaction){
        $payment = static::where('id_transaction',$id_transaction)->first();
        if($payment == null):
            return 1;
        else:
            return 0;
        endif;
    }

}

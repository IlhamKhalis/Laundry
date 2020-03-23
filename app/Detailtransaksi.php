<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detailtransaksi extends Model
{
    protected $table="detail_transaksi";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id_transaksi', 'id_jenis', 'qty', 'subtotal'
    ];
    public function Transaksi(){
        return $this()->belongsTo('App\Transaksi','id_transaksi');
    }
    public function Jeniscuci(){
        return $this()->belongsTo('App\Jeniscuci','id_jenis');
    }

}

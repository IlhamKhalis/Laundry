<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table="transaksi";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id_pelanggan', 'id_petugas', 'tgl_transaksi', 'tgl_selesai'
    ];
    public function Petugas(){
        return $this()->belongsTo('App\Petugas','id_petugas');
    }
    public function Pelanggan(){
        return $this()->belongsTo('App\Pelanggan','id_pelanggan');
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detailtransaksi;
use App\Jeniscuci;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class DetailtransaksiController extends Controller
{
    public function store(Request $req){
        if (Auth::user()->level=='petugas') {
            $validator=Validator::make($req->all(),[
                'id_transaksi' => 'required',
                'id_jenis' => 'required',
                'qty' => 'required',
              ]);
              if($validator->fails()){
                return Response()->json($validator->errors());
              }

              $harga = JenisCuci::where('id', $req->id_jenis)->first();
              $subtotal = $harga->harga_per_kilo * $req->qty;
        
              $simpan=Detailtransaksi::create([
                  'id_transaksi' => $req->id_transaksi,
                  'id_jenis' => $req->id_jenis,
                  'qty' => $req->qty,
                  'subtotal' => $subtotal,
              ]);
              if($simpan){
                  $data['status']="Berhasil";
                  $data['message']="Data berhasil disimpan!";
                  return Response()->json($data);
              }else{
                  $data['status']="Gagal";
                  $data['message']="Data gagal disimpan!";
                  return Response()->json($data);
              }
        } else {
            $data['status']="Gagal";
            $data['Message']="Anda bukan Petugas!";
            return Response()->json($data);
        }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'petugas'){

        $validator = Validator::make($req->all(),
        [
            'id_transaksi'=>'required',
            'id_jenis'=>'required',
            'qty'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $harga = Jeniscuci::where('id',$req->id_jenis)->first();
        $subtotal = $harga->harga_perkilo * $req->qty;

        $ubah = Detailtransaksi::where('id', $id)->update([
            'id_transaksi'=> $req->id_transaksi,
            'id_jenis'=> $req->id_jenis,
            'subtotal'=> $subtotal,
            'qty'=> $req->qty
        ]);
        if($ubah){
            return Response()->json('Data Detail Transaksi berhasil diubah');
        }else{
            return Response()->json('Data Detail Transaksi gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Detailtransaksi::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Detail Transaksi berhasil dihapus');
        }else{
            return Response()->json('Data Detail Transaksi gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan admin');
    }
    }
}

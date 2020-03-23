<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{

    public function store(Request $req){
        if(Auth::user()->level == 'petugas'){
        
        $validator = Validator::make($req->all(),
        [
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required',
            'tgl_selesai'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan = Transaksi::create([
            'id_pelanggan'=>$req->id_pelanggan,
            'id_petugas'=>$req->id_petugas,
            'tgl_transaksi'=>$req->tgl_transaksi,
            'tgl_selesai'=>$req->tgl_selesai
            
        ]);
        if($simpan){
            return Response()->json('Data Transaksi berhasil ditambahkan');
        }else{
            return Response()->json('Data Transaksi gagal ditambahkan');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
    }

    public function update($id,Request $req){
        if(Auth::user()->level == 'petugas'){

        $validator = Validator::make($req->all(),
        [
            'id_pelanggan'=>'required',
            'id_petugas'=>'required',
            'tgl_transaksi'=>'required',
            'tgl_selesai'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $ubah = Transaksi::where('id', $id)->update([
            'id_pelanggan'=>$req->id_pelanggan,
            'id_petugas'=>$req->id_petugas,
            'tgl_transaksi'=>$req->tgl_transaksi,
            'tgl_selesai'=>$req->tgl_selesai
        ]);
        if($ubah){
            return Response()->json('Data Transaksi berhasil diubah');
        }else{
            return Response()->json('Data Transaksi gagal diubah');
        }
    }else{
        return Response()->json('Anda Bukan Petugas');
    }
    }

    public function destroy($id){
        if(Auth::user()->level == 'admin'){

        $hapus = Transaksi::where('id', $id)->delete();
        if($hapus){
            return Response()->json('Data Transaksi berhasil dihapus');
        }else{
            return Response()->json('Data Transaksi gagal dihapus');
        }
    }else{
        return Response()->json('Anda Bukan Admin');
    }
    }

    public function show(Request $req){
        if(Auth::user()->level == "petugas"){
            $transaksi = DB::table('transaksi')->join('pelanggan','pelanggan.id','=','transaksi.id_pelanggan')
            ->where('transaksi.tgl_transaksi','>=',$req->tgl_transaksi)
            ->where('transaksi.tgl_transaksi','<=',$req->tgl_selesai)
            ->select('nama','telp','alamat','transaksi.id','tgl_transaksi','tgl_selesai')
            ->get();
            
            if($transaksi->count() > 0){
            $data_transaksi = array();
            foreach ($transaksi as $t){
                $grand = DB::table('detail_transaksi')->where('id_transaksi','=',$t->id)
                ->groupBy('id_transaksi')
                ->select(DB::raw('sum(subtotal) as grandtotal'))
                ->first();
                
                $detail = DB::table('detail_transaksi')->join('jenis_cuci','detail_transaksi.id_jenis','=','jenis_cuci.id')
                ->where('id_transaksi','=',$t->id)
                ->get();
                
                $data_transaksi[] = array(
                    'Tanggal' => $t->tgl_transaksi,
                    'Nama Pelanggan' => $t->nama,
                    'Alamat' => $t->alamat,
                    'No Telp' => $t->telp,
                    'Tanggal Ambil' => $t->tgl_selesai,
                    'Grand Total' => $grand, 
                    'Detail' => $detail,
                );
            }
            return response()->json(compact('data_transaksi'));
    }else{
            $status = 'tidak ada transaksi antara tanggal '.$req->tgl_transaksi.' sampai dengan tanggal '.$req->tgl_selesai;
            return response()->json(compact('status'));
    }
        }else{
            return Response()->json('Anda Bukan Petugas');
        }
}
}


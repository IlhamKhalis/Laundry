<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jeniscuci;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class JeniscuciController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $jeniscuci=DB::table('jenis_cuci')
            ->where('jenis_cuci.id',$id)
            ->get();
            return response()->json($jeniscuci);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_per_kilo'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=Jeniscuci::create([
            'nama_jenis'=>$req->nama_jenis,
            'harga_per_kilo'=>$req->harga_per_kilo
        ]);
        $status=1;
        $message="Jenis Cuci Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan admin']);
      }
  }
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'nama_jenis'=>'required',
                'harga_per_kilo'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=Jeniscuci::where('id',$id)->update([
            'nama_jenis'=>$request->nama_jenis,
            'harga_per_kilo'=>$request->harga_per_kilo
        ]);
        $status=1;
        $message="Jenis Cuci Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan admin']);
    }
}
    public function destroy($id){
        if(Auth::user()->level=="admin"){
        $hapus=Jeniscuci::where('id',$id)->delete();
        $status=1;
        $message="Jenis Cuci Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan admin']);
        }
    }
  
    public function tampil(){
        if(Auth::user()->level=="admin"){
            $datas = Jeniscuci::get();
            $count = $datas->count();
            $jeniscuci = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $jeniscuci[] = array(
                    'id' => $dt_jc->id,
                    'nama_jenis' => $dt_jc->nama_jenis,
                    'harga_per_kilo' => $dt_jc->harga_per_kilo
                );
            }
            return Response()->json(compact('count','jeniscuci'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}

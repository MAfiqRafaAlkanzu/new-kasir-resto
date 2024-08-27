<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Detail;
use App\Models\Menu;
use App\Models\Seat;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return view('backend.transaction.list-of-transaction');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::all();
            return Datatables::of($data)
                                        ->addIndexColumn()
                                        ->editColumn('user', function($data){
                                            return $data->user->name;
                                        })
                                        ->editColumn('customer_name', function($data){
                                            return $data->customer_name;
                                        })
                                        ->editColumn('seat', function($data){
                                            return $data->seat->seat_number;
                                        })
                                        ->editColumn('status', function($data){
                                            return $data->status;
                                        })
                                        ->editColumn('action', function($data){
                                            return '<div class="input-group d-flex w-25"><div class="input-group-btn d-flex justify-items-center align-items-center"><a class="btn btn-outline-primary btn-sm" href="'.route('transaction.detailpage', ['id' => $data->id]).'"><i class="ti-eye"></i> Detail</a></div></div>';
                                        })
                                        ->rawColumns(['action'])
                                        ->make();        
        }
    }

    public function add()
    {
        $menu = Menu::all();
        $seat = Seat::where('status', 'available')->get();

        return view('backend.transaction.add',[
            'menu' => $menu,
            'seat' =>$seat
        ]);
    }

    public function newInsert(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'seat_id' => 'required',
            'customer_name' => 'required',       
        ]);
        $get_seat = DB::table('seats')->where('id', $request->seat_id)->get(); //cek status meja

        $update_meja = Seat::where('id', $request->seat_id)->update([
            'status' => 'not available'
        ]);

        $transaksi = new Transaction();
        $transaksi->user_id = $request->user_id;
        $transaksi->seat_id = $request->seat_id;
        $transaksi->customer_name = $request->customer_name;
        $transaksi->status = 'unpayed';
		$transaksi->save();
        
        for($i = 0; $i < count($request->detail); $i++){
            $detail_transaksi = new Detail();
            $detail_transaksi->transaction_id = $transaksi->id;
            $detail_transaksi->menu_id = $request->detail[$i]['menu_id'];
            $detail_transaksi->qty = $request->detail[$i]['qty'];
            $menu = Menu::where('id', '=', $detail_transaksi->menu_id)->first();
            $harga = $menu->price;
            $detail_transaksi->subtotal = $request->detail[$i]['qty'] * $harga;
            $menu->stock -= $detail_transaksi->qty;
            
            // Check if stock goes below zero
            if($menu->stock < 0) {
                DB::rollBack(); // Rollback the transaction
                return redirect()->back()->withErrors(['error' => 'Not enough stock available for ' . $menu->name]);
            }
            $detail_transaksi->save();
            $menu->save();

        }

        // dd($detail_transaksi);

        DB::commit(); // Commit the transaction

        $detail = Detail::where('transaction_id', '=', $detail_transaksi->transaction_id)->get();

        return redirect()->back()->with('success', 'Your transaction is successfull')->with('id', $transaksi->id);
    }

    public function payment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tunai' => 'required|numeric',    
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $total = DB::select("SELECT transaction_id, SUM(subtotal) as 'total' from details WHERE transaction_id = $id GROUP BY transaction_id");
        $total_akhir = intval($total[0]->total);
        $kembali = $request->tunai - $total_akhir;

        if ($request->tunai < $total_akhir) {
            return redirect()->back()->with('error', 'Tunai kurang')->withInput();
        }

        $update_bayar = Transaction::where('id', $id)->update([
            'status' => 'payed'
        ]);

        $get_meja = DB::table('transactions')->where('id', $id)->get(); //get status meja

        $update_meja = Seat::where('id', $get_meja[0]->seat_id)->update([
            'status' => 'available'
        ]);

        return redirect()->back()->with('success', 'Your change is Rp.'.$kembali); 
    }

    public function paymentPage(Request $request, Session $session)
    {
        $total = Detail::where('transaction_id', session('id'))->sum('subtotal');
        return view('backend.transaction.payment',[
            'total' => $total
        ]);
    }

    public function detailpage($id)
    {
        $data = Detail::where('transaction_id', $id)->get();
        $total = Detail::where('transaction_id', $id)->sum('subtotal');   
        return view('backend.transaction.list-of-detailtransaction',[
            'id' => $id,
            'total' => $total
            ]);
    }

    public function detail($id, Request $request)
    {
        $data = Detail::where('transaction_id', $id)->get();

            return Datatables::of($data)
                                        ->addIndexColumn()
                                        ->editColumn('menu', function($data){
                                            return $data->menu->name;
                                        })
                                        ->editColumn('qty', function($data){
                                            return $data->qty;
                                        })
                                        ->editColumn('subtotal', function($data){
                                            return $data->subtotal;
                                        })
                                        ->rawColumns(['action'])
                                        ->make();        
        // }
    }
}
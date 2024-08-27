<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Menu;
use App\Models\Seat;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CashierController extends Controller
{
    public function index()
    {
        $menu = Menu::all();
        $seat = Seat::where('status', 'available')->get();
        return view('backend.cashier.transaction-list', [
            'menu' => $menu,
            'seat' => $seat,
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::where('user_id', Auth::user()->id);
            return DataTables::of($data)
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
                                            if ($data->status == 'unpayed') {
                                                return '<span class="badge badge-danger badge-pill"> Unpaid </span>';
                                            }
                                            else{
                                                return '<span class="badge badge-success badge-pill"> Paid </span>';
                                            }
                                        })
                                        ->editColumn('action', function($data){
                                           if ($data->status === "payed") {
                                            return '<div class="input-group d-flex w-25"><div class="input-group-btn d-flex justify-items-center align-items-center"></div></div>';
                                           } else {
                                            return '<div class="input-group d-flex w-25"><div class="input-group-btn d-flex justify-items-center align-items-center"><button class="btn btn-outline-primary btn-sm edit-data" data-id='.$data->id.' data-toggle="modal" data-target="#paymentmodal"><i class="ti-pencil"></i> Edit</button></div></div>';
                                           }   
                                        })
                                        ->rawColumns(['action', 'status'])
                                        ->make();        
        }
    }

    public function getTotal($id)
    {
        $data = Detail::where('transaction_id', $id)->sum('subtotal');

        return response()->json($data);
    }
}

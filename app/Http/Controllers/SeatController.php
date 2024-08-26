<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Yajra\DataTables\Facades\DataTables;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return view('backend.seat.list-of-seat');
    }

    public function data(Request $request){

        if ($request->ajax()) {
            $seat = Seat::select()->get();
            // dd($seat);
            return DataTables::of($seat)
                                        ->addIndexColumn()
                                        ->editColumn('seat_number', function($seat){
                                            return $seat->seat_number;
                                        })
                                        ->editColumn('status', function($seat){
                                            return $seat->status;
                                        })
                                        ->editColumn('action', function($seat){
                                            return '<div class="input-group d-flex justify-content-between"><div class="input-group-btn"><a class="btn btn-outline-primary btn-sm" href="'.route('seat.edit', ['id' => $seat->id]).'"><i class="ti-pencil"></i> Edit</a><button class="btn btn-outline-danger btn-sm delete-btn" type="button" onclick="confirmDelete('.$seat->id.')"><i class="ti-trash" data-id="'.$seat->id.'"></i> Delete</button></div></div>';
                                        })
                                        ->rawColumns(['action'])
                                        ->make();        
        }
    }

    public function add(){

        return view('backend.seat.add');
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'seat_number' => 'required|unique:seats',
            'status' => 'required'
        ]);

        Seat::create($validatedData);

        return redirect()->back()->with('success', 'Data has been added');
    }

    public function edit($id)
    {
        $seat = Seat::where('id', $id)->first();
        return view('backend.seat.edit', [
            'seat'=> $seat
        ]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'seat_number' => 'required|unique:seats',
            'status' => 'required'
        ]);

        Seat::where('id', $id)->update($validatedData);

        return redirect()->back()->with('success', 'Your data has been updated');
    }

    public function delete($id, Request $request)
    {
        Seat::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Your seat data has been deleted');
    }
}

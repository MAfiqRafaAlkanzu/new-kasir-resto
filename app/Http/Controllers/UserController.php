<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function list()
    {
        return view('backend.user.list-user');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $user = User::select()->get();

            return Datatables::of($user)
                                        ->addIndexColumn()
                                        ->editColumn('name', function($user){
                                            return $user->name;
                                        })
                                        ->editColumn('email', function($user){
                                            return $user->email;
                                        })
                                        ->editColumn('password', function($user){
                                            return $user->password;
                                        })
                                        ->editColumn('role', function($user){
                                            return $user->roles;
                                        })
                                        ->editColumn('action', function($user){
                                            return '<div class="input-group d-flex w-25"><div class="input-group-btn"><a class="btn btn-outline-primary btn-sm" href="'.route('user.edit', ['userId' => $user->id]).'"><i class="ti-pencil"></i> Edit</a><button class="btn btn-outline-danger btn-sm delete-btn" type="button" onclick="confirmDelete('.$user->id.')"><i class="ti-trash" data-id="'.$user->id.'"></i> Delete</button></div></div>';
                                        })
                                        ->rawColumns(['image', 'action'])
                                        ->make();        
        }
    }


    public function edit($userId)
    {
        $user = User::where('id', $userId)->first();
        // dd($menu);
        return view('backend.user.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $userId)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::where('id', $userId)->update($validatedData);

        return redirect()->back()->with('success', 'Your data has been updated');
    }

    public function delete($id, Request $request)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Your data has been deleted');
    }
}

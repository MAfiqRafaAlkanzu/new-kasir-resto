<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return view('backend.menu.list-of-menu');
    }

    public function data(Request $request)
    {   
        // $menu = Menu::all();
        // dd($menu);
        if ($request->ajax()) {
            $menu = Menu::select()->get();

            return Datatables::of($menu)
                                        ->addIndexColumn()
                                        ->editColumn('name', function($menu){
                                            return $menu->name;
                                        })
                                        ->editColumn('type', function($menu){
                                            return $menu->type;
                                        })
                                        ->editColumn('description', function($menu){
                                            return $menu->description;
                                        })
                                        ->editColumn('image', function($menu){
                                            return '<img src="'.asset($menu->image).'" style="width:120px;height:120px;margin:0px !important"/>';
                                        })
                                        ->editColumn('price', function($menu){
                                            return $menu->price;
                                        })
                                        ->editColumn('stock', function($menu){
                                            return $menu->stock;
                                        })
                                        ->editColumn('action', function($menu){
                                            return '<div class="input-group d-flex w-25"><div class="input-group-btn"><a class="btn btn-outline-primary btn-sm" href="'.route('menu.edit', ['menuId' => $menu->id]).'"><i class="ti-pencil"></i> Edit</a><button class="btn btn-outline-danger btn-sm delete-btn" type="button" onclick="confirmDelete('.$menu->id.')"><i class="ti-trash" data-id="'.$menu->id.'"></i> Delete</button></div></div>';
                                        })
                                        ->rawColumns(['image', 'action'])
                                        ->make();        
        }
    }

    public function add()
    {
        return view('backend.menu.add');
    }

    public function insert(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if($request->file('image')) {
            $image = $request->file('image');
    
            // Create a custom filename (e.g., a combination of the current timestamp and the original filename)
            $filename = time() . '_' . $image->getClientOriginalName();
    
            // Store the file in the 'image' directory with the custom name
            $path = $image->storeAs('image', $filename);
    
            // Save the custom path to the database
            $validatedData['image'] = $path;
        }

        Menu::create($validatedData);

        return redirect()->back()->with('success', 'Data has been added');
    }

    public function editMenu($menuId){

        $menu = Menu::where('id', $menuId)->first();
        return view('backend.menu.edit', [
            'menu' => $menu
        ]);
    }

    public function updateMenu(Request $request, $menuId)
    {
        $menu = Menu::where('id', $menuId)->first();
        // $path = asset('storage/'.$menu->image);

        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
            'stock' => 'required'
        ]);

        if($request->file('image')) {
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $image = $request->file('image');
    
            // Create a custom filename (e.g., a combination of the current timestamp and the original filename)
            $filename = time() . '_' . $image->getClientOriginalName();
    
            // Store the file in the 'image' directory with the custom name
            $path = $image->storeAs('image', $filename);
    
            // Save the custom path to the database
            $validatedData['image'] = $path;
        }

            Menu::where('id', $menuId)->update($validatedData);

            return redirect()->back()->with('success', 'Data has been updated');
    }

    public function deleteMenu($menuId, Request $request){

        Menu::where('id', $request->id)->delete();

        return redirect()->back()->with('success', 'Your menu has been deleted!');
    }
}

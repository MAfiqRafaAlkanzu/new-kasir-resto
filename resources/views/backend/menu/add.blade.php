@extends('layouts.master')

@section('title', 'Add New Source')

@section('custom-css')
    <link href="{{ asset('backend') }}/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-content')

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">Insert New Menu</div>
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable fade show text-center">
                    <button class="close" data-dismiss="alert" aria-label="Close"></button>
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="ibox-body">
                    <form action="{{ route('menu.insert_new') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Menu Name" value="" name="name" required>
                                @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="type">Type</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('type') is-invalid @enderror" name="type">
                                    <option value="Food">Food</option>
                                    <option value="Drink">Drink</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="description">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id=""rows="3"></textarea>
                                @error('description')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="image">Image</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('image') is-invalid @enderror" type="file" placeholder="Menu Name" value="" name="image" required accept=".jpg, .png, .jpeg">
                                @error('image')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="price">Price</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('price') is-invalid @enderror" type="text" placeholder="Price" value="" name="price" required>
                                @error('price')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="stock">Stock</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('stock') is-invalid @enderror" type="text" placeholder="Stock" value="" name="stock" required>
                                @error('stock')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    <div class="ibox-footer">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary ml-2 pull-right" type="submit">Save new menu</button>
                    </form>      
                </div>
            </div>
        </div>
    </div>    
@endsection
    
@section('custom-js')
    <script src="{{ asset('backend') }}/assets/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/scripts/form-plugins.js"></script>
@endsection
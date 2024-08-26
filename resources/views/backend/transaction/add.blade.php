@extends('layouts.master')

@section('title', 'Add New Table')

@section('custom-css')
    <link href="{{ asset('backend') }}/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">Add New Transaction</div>
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable fade show text-center">
                    <button class="close" data-dismiss="alert" aria-label="Close"></button>
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="ibox-body">
                    <form action="{{ route('transaction.insert_new') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="status" value="unpayed">
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="table_number">Table Number</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('type') is-invalid @enderror" name="type">
                                    @foreach ($table as $item)
                                    <option value="{{ $item->id }}">{{ $item->table_number }}</option>
                                    @endforeach
                                </select>
                                @error('table_number')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="customer_name">Customer name</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('customer_name') is-invalid @enderror" type="text" placeholder="Customer Name" value="" name="customer_name" required>
                                @error('customer_name')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="menu">Menu</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('menu') is-invalid @enderror" type="text" placeholder="Menu" value="" name="menu" required>
                                @error('menu')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <div class="ibox-footer">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary ml-2 pull-right" type="submit">Save new table</button>
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
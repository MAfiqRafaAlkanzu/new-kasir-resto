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
                <div class="ibox-title">Payment</div>
            </div>
            @if(Session::has('success'))
            <div class="alert alert-success text-center">
                {{Session::get('success')}}
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger text-center">
                {{Session::get('error')}}
            </div>
            @endif
            <div class="ibox-body">
                <form action="{{ route('transaction.payment', ['id' => session('id')]) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-4 row">
                        <label class="col-sm-2 col-form-label" for="total">Total</label>
                        <div class="col-sm-10">
                            <input class="form-control @error('total') is-invalid @enderror" type="text" placeholder="Total" value="{{ $total }}" name="total" required disabled>
                            @error('total')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-4 row">
                        <label class="col-sm-2 col-form-label" for="tunai">Total</label>
                        <div class="col-sm-10">
                            <input class="form-control @error('tunai') is-invalid @enderror" type="number" placeholder="Tunai" value="" name="tunai" required style="-moz-appearance: textfield;">
                            @error('tunai')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="ibox-footer">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary ml-2 pull-right" type="submit">Pay</button>
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
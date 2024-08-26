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
                    <div class="ibox-title">Insert New Seat</div>
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable fade show text-center">
                    <button class="close" data-dismiss="alert" aria-label="Close"></button>
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="ibox-body">
                    <form action="{{ route('seat.insert_new') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="seat_number">Seat Number</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('seat_number') is-invalid @enderror" type="text" placeholder="Seat Number" value="" name="seat_number" required>
                                @error('seat_number')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('status') is-invalid @enderror" name="status">
                                    <option value="available">Available</option>
                                    <option value="not available">Not Available</option>
                                </select>
                                @error('status')
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
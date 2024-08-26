@extends('layouts.master')

@section('title', 'Dashboard')

@section('custom-css')
    <link href="{{ asset('backend') }}/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-content')
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    {{-- <div class="ibox-title">Add New Transaction</div> --}}
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success text-center">
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="ibox-body">
                    <h2 class="text-center">Welcome, {{ auth()->user()->name }}</h2>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('custom-js')
    <script src="{{ asset('backend') }}/assets/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/scripts/form-plugins.js"></script>

    <script>
        let detailCount = 1;
        document.getElementById('add-detail').addEventListener('click', function() {
            let container = document.getElementById('detail-container');
            let detailItem = document.createElement('div');
            detailItem.classList.add('detail-item', 'row', 'mr-auto', 'ml-auto', 'mb-2');
            detailItem.innerHTML = `
            <select class="form-control @error('menu') is-invalid @enderror col-sm-8 mr-1" name="detail[${detailCount}][menu_id]">
                @foreach ($menu as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select> </br>
            <input class="form-control @error('qty') is-invalid @enderror col-sm-3 ml-1" type="phone" name="detail[${detailCount}][qty]" placeholder="Qty"></br>
            `;
            container.appendChild(detailItem);
            detailCount++;
        });
    </script>
@endsection
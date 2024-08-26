@extends('layouts.master')

@section('title', 'Edit Menu')

@section('custom-css')
    <link href="{{ asset('backend') }}/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-content')

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">Edit Menu</div>
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable fade show text-center">
                    <button class="close" data-dismiss="alert" aria-label="Close"></button>
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="ibox-body">
                    <form action="{{ route('seat.update', ['id' => $seat->id]) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="seat_number">Seat Number</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('seat_number') is-invalid @enderror" type="text" placeholder="Menu Name" value="{{ $seat->seat_number }}" name="seat_number" required>
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
                                    <option value="available"  {{ $seat->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ $seat->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
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
                        <button class="btn btn-primary ml-2 pull-right" type="submit">Update Seat</button>
                    </form>      
                </div>
            </div>
        </div>
    </div>    
@endsection
    
@section('custom-js')
    <script src="{{ asset('backend') }}/assets/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/scripts/form-plugins.js"></script>

    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = "block";

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
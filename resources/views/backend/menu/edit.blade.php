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
                    <form action="{{ route('menu.update', ['menuId' => $menu->id]) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Menu Name" value="{{ $menu->name }}" name="name" required>
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
                                    <option value="Food"  {{ $menu->type == 'Food' ? 'selected' : '' }}>Food</option>
                                    <option value="Drink" {{ $menu->type == 'Drink' ? 'selected' : '' }}>Drink</option>
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
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id=""rows="3">{{ $menu->description }}</textarea>
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
                                <input type="hidden" name="oldImage" value="{{ $menu->image }}">
                                @if ($menu->image)
                                    <img src="{{ asset('image/'.$menu->image) }}" alt="" class="img-preview img-fluid mb-3 col-sm-5 d-block" style="max-width: 120px;max-height:120px">
                                @else 
                                    <img class="img-preview img-fluid mb-3 col-sm-5" >
                                @endif
                                <input class="form-control @error('image') is-invalid @enderror" type="file" placeholder="Menu Name" value="" name="image" id="image" accept=".jpg, .png, .jpeg" required onchange="previewImage()">
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
                                <input class="form-control @error('price') is-invalid @enderror" type="text" placeholder="Price" value="{{ $menu->price }}" name="price" required>
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
                                <input class="form-control @error('stock') is-invalid @enderror" type="text" placeholder="Stock" value="{{ $menu->stock }}" name="stock" required>
                                @error('stock')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    <div class="ibox-footer">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary ml-2 pull-right" type="submit">Update menu</button>
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
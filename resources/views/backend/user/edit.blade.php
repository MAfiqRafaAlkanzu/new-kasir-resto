@extends('layouts.master')

@section('title', 'Edit User')

@section('custom-css')
    <link href="{{ asset('backend') }}/assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('page-content')

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="ibox ibox-fullheight">
                <div class="ibox-head">
                    <div class="ibox-title">Edit User</div>
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable fade show text-center">
                    <button class="close" data-dismiss="alert" aria-label="Close"></button>
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="ibox-body">
                    <form action="{{ route('user.update', ['userId' => $user->id]) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Menu Name" value="{{ $user->name }}" name="name" required>
                                @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Menu Name" value="{{ $user->email }}" name="email" required>
                                @error('email')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" value="" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-4 row">
                            <label class="col-sm-2 col-form-label" for="roles">Roles</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('roles') is-invalid @enderror" name="roles">
                                    <option value="cashier"  {{ $user->roles == 'cashier' ? 'selected' : '' }}>Cashier</option>
                                    <option value="manager" {{ $user->roles == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="admin" {{ $user->roles == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('roles')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <div class="ibox-footer">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                        <button class="btn btn-primary ml-2 pull-right" type="submit">Update user</button>
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
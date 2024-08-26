@extends('layouts.master')

@section('title', 'List Menu')

@section('plugin-css')
<link href="{{ asset('backend') }}/assets/vendors/dataTables/datatables.min.css" rel="stylesheet" />
<link href="{{ asset('backend') }}/assets/vendors/bootstrap-sweetalert/dist/sweetalert.css" rel="stylesheet" />

<style>
        #datatable td:last-child {
            max-width: 100%;
        }
        #datatable td {
            white-space: nowrap;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #datatable_wrapper {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
        }
        
        table#datatable{
            border-collapse: collapse !important
        }

        #dataTables_processing{
            border: 1px solid black;
            z-index: 105;
        }
</style>
@endsection

@section('page-content')
<div class="ibox">
    <div class="ibox-head">
        <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary"><i class="ti ti-arrow-left"></i> Back</a>
        <span class="pull-right" ><i class="fa fa-info-circle"></i> Menu</span>
    </div>
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissable fade show text-center">
        <button class="close" data-dismiss="alert" aria-label="Close"></button>
        {{Session::get('success')}}
    </div>
    @endif
    <div class="ibox-body">
        <h1 class="font-strong mb-4">All Seat</h1>
        <div class="flexbox mb-4">
            <div class="flexbox mr-4">
                <label class="mb-0 mr-2">Status:</label>
                <select class="selectpicker show-tick form-control" id="type-filter" title="Please select" data-style="btn-solid" data-width="150px">
                    <option value="">All</option>
                    <option value="available">Available</option>
                    <option value="not available">Not Available</option>
                </select>
            </div>
            <div class="input-group">
                <div class="input-group-btn">
                    <a href="{{ route('seat.add') }}" class="btn btn-info"><i class="fa fa-plus"></i> Add New Seat<strong id="menu"></strong></a>
                </div>
            </div>
            <div class="input-group-icon input-group-icon-left mr-3">
                <span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span>
                <input class="form-control form-control-rounded form-control-solid" id="key-search" type="text" placeholder="Search ...">
            </div>
        </div>
        <div class="table-responsive row" style="overflow: auto;">
            <table class="table table-bordered table-hover" id="dataTables">
                <thead class="thead-default thead-lg">
                    <tr>
                        <th>#</th>
                        <th>Seat Number</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th hidden>
                            <input type="hidden" name="token" id="" value="{{ csrf_token() }}">
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('plugin-js')
    <script src="{{ asset('backend') }}/assets/vendors/dataTables/datatables.min.js"></script>    
    <script src="{{ asset('backend') }}/assets/js/app.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            var table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('seat.data') }}",
                language: {
                    loadingRecords: '&nbsp;',
                    "processing": "<span class='fa-stack fa-lg border-b-2'>\n\
                                    <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                                    </span>&emsp;Processing ...",
                },
                pageLength: 10,
                fixedHeader: true,
                responsive: true,
                "sDom": 'rtip',
                columnDefs: [
                    {
                        targets: 'no-sort',
                        orderable: false
                    },
                ],
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'seat_number', name: 'seat_number' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false },
                ]
            });

            $('#key-search').on('keyup', function(e) {
                if(e.keyCode == 13) {
                    table.search( this.value ).draw();
                }
            });
            $('#type-filter').on('change', function() {
                table.column(2).search($(this).val()).draw();
            });
        });

    </script>
    <script>
        function confirmDelete(id) {
            var table = $('#dataTables').DataTable();        
            var token = $("input[name=token]").val();
            var deleteUrl = '{{ route('seat.delete',['id'=> ':id']) }}'; 
            deleteUrl = deleteUrl.replace(':id', id); 
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel pls!",
                closeOnConfirm: false,
                closeOnCancel: false
            },function (isConfirm) {
                if (isConfirm) {
                    $.ajax({ 
                        type: 'POST', 
                        url: deleteUrl,  
                        data: {
                            _token: token,
                            'id' : id
                            }, 
                        success: function () {  
                            table.ajax.reload();
                            swal( 
                                'Deleted!', 
                                'Your data has been deleted.', 
                                'success' 
                                )
                        },
                        error: function () {
                            swal("NOT Deleted!", "Something blew up.", "error");
                        } 
                    });
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            });
        };
    </script>
@endsection

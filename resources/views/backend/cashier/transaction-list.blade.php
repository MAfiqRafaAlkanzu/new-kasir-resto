@extends('layouts.master')

@section('title', 'List Transactions')

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
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
</style>
@endsection

@section('page-content')
<div class="ibox">
    <div class="ibox-head">
        <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary"><i class="ti ti-arrow-left"></i> Back</a>
        <span class="pull-right" ><i class="fa fa-info-circle"></i> Transactions</span>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close"></button>
            {{Session::get('success')}}
        </div>
    @endif
    <div class="ibox-body">
        <h1 class="font-strong mb-4">All Transactions</h1>
        <div class="flexbox mb-4">
            <div class="flexbox mr-4">
                <label class="mb-0 mr-2">Status:</label>
                <select class="selectpicker show-tick form-control" id="type-filter" title="Please select" data-style="btn-solid" data-width="150px">
                    <option value="">All</option>
                    <option value="payed">Payed</option>
                    <option value="unpayed">Not Payed</option>
                </select>
            </div>
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transactiomodal">
                        New Transaction
                    </button>
                </div>
            </div>
            <div class="modal fade" id="transactiomodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body modal-new-transaction">
                            <!-- your form here -->
                            <form action="{{ route('transaction.newinsert') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="status" value="unpayed">
                                <div class="form-group mb-4 row">
                                    <label class="col-sm-2 col-form-label" for="user">User</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('user') is-invalid @enderror" type="text" placeholder="Customer Name" value="{{ auth()->user()->name }}" name="user" required disabled>
                                        @error('user')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4 row">
                                    <label class="col-sm-2 col-form-label" for="seat_id">Seat Number</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('seat_id') is-invalid @enderror" name="seat_id">
                                            @foreach ($seat as $item)
                                            <option value="{{ $item->id }}">{{ $item->seat_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('seat_id')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4 row">
                                    <label class="col-sm-2 col-form-label" for="customer_name">Customer Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('customer_name') is-invalid @enderror" type="text" name="customer_name" placeholder="Customer Name" required>
                                        @error('customer_name')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" id="add-detail" class="btn btn-blue">Add Menu</button><br><br>
                                <div class="form-group mb-4 row">
                                    <label class="col-sm-2 col-form-label" for="menu">Menu</label>
                                    <div class="col-sm-10" id="detail-container">
                                        <div class="detail-item row mr-auto ml-auto mb-2">
                                            <select class="form-control @error('menu') is-invalid @enderror col-sm-4 mr-1 menu-select" name="detail[0][menu_id]">
                                                @foreach ($menu as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select> </br>
                                            <input class="form-control @error('qty') is-invalid @enderror col-sm-2 ml-1 qty-input" type="number" name="detail[0][qty]" placeholder="Qty"></br>
                                            <input class="form-control @error('subtotal') is-invalid @enderror col-sm-4 ml-1 subtotal-input" type="number" name="detail[0][subtotal]" placeholder="Subtotal" readonly>
                                            <button class="close col-sm-1 deleteBtn"></button>
                                            @error('menu')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal fade" id="paymentmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body modal-new-transaction">
                            <!-- your form here -->
                            <form action="" class="form-horizontal" method="POST" enctype="multipart/form-data" id="paymentForm">
                                @csrf
                                @method('POST')
                                <div class="form-group mb-4 row">
                                    <label class="col-sm-2 col-form-label" for="total">Total</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('total') is-invalid @enderror" type="text" placeholder="Total" name="total" required disabled>
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary payment-btn">Pay</button>
                            </div>
                        </div>
                    </form>
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
                        <th>User</th>
                        <th>Seat</th>
                        <th>Customer Name</th>
                        <th>Status</th>
                        <th></th>
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
                ajax: "{{ route('cashier.data') }}",
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
                    { data: 'user', name: 'user' , orderable: false},
                    { data: 'seat', name: 'seat' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' , orderable: false},
                ]
            });

            $('#key-search').on('keyup', function(e) {
                if(e.keyCode == 13) {
                    table.search( this.value ).draw();
                }
            });
            $('#type-filter').on('change', function() {
                table.column(4).search($(this).val()).draw();
            });
        });

    </script>
    <script>
        function confirmDelete(id) {
            var table = $('#dataTables').DataTable();        
            var token = $("input[name=token]").val();
            var deleteUrl = '{{ route('menu.delete',['menuId'=> ':id']) }}'; 
            deleteUrl = deleteUrl.replace(':id', id); 
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
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

    <script>
        let detailCount = 1;
        document.getElementById('add-detail').addEventListener('click', function() {
            let container = document.getElementById('detail-container');
            let detailItem = document.createElement('div');
            detailItem.classList.add('detail-item', 'row', 'mr-auto', 'ml-auto', 'mb-2');
            detailItem.innerHTML = `
            <select class="form-control @error('menu') is-invalid @enderror col-sm-4 mr-1 menu-select" name="detail[${detailCount}][menu_id]">
                                                @foreach ($menu as $item)
                                                <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select> </br>
                                            <input class="form-control @error('qty') is-invalid @enderror col-sm-2 ml-1 qty-input" type="number" name="detail[${detailCount}][qty]" placeholder="Qty"></br>
                                            <input class="form-control @error('subtotal') is-invalid @enderror col-sm-4 ml-1 subtotal-input" type="number"  name="detail[${detailCount}][subtotal]" placeholder="Subtotal" readonly>
                                            <button class="close col-sm-1 deleteBtn"></button>
            `;
            container.appendChild(detailItem);
            detailCount++;
        });
    </script>
    <script>
        document.addEventListener('input', function(event) {
            // Cek apakah input yang diubah berada pada kolom qty
            if (event.target.classList.contains('qty-input')) {
                // Ambil harga dari atribut data-price pada opsi dropdown menu yang dipilih
                let price = parseFloat(event.target.closest('.detail-item').querySelector('.menu-select').selectedOptions[0].getAttribute('data-price'));

                // Ambil nilai qty dari input yang diubah
                let qty = parseInt(event.target.value);

                // Hitung subtotal
                let subtotal = price * qty;

                // Tampilkan subtotal pada kolom subtotal yang sesuai
                event.target.closest('.detail-item').querySelector('.subtotal-input').value = subtotal;
            }
        });
    </script>

    <script>
        $(document).on('click', '.edit-data', function(){
            var id = $(this).data('id');
            $.ajax({
                url: '/cashier/total/' + id,
                type: 'GET',
                success:function(response){
                    $('#modal-body').html(response);
                    $('#paymentmodal').modal('show');
                    $('input[name=total]').val(response);
                    $('#paymentForm').attr('action', '/payment/' + id);
                }
            });
        });

        $(document).on('click', '.deleteBtn', function(e) {
            e.preventDefault();
            $(this).closest('.detail-item').remove();
        });
    </script>
    

@endsection

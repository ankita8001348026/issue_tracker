@extends('backend.layouts.main')
@section('title', 'Employee')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">Employee</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="card card-outline card-primary">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" autocomplete="off">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg">
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <input type="text" name="date"
                                                        class="form-control js-daterange-picker"
                                                        placeholder="Select Date Range">
                                                    <input type="hidden" name="start_date" class="form-control">
                                                    <input type="hidden" name="end_date" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select class="form-control select2bs4" name="status">
                                                        <option value="">---Select---</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg">
                                                <div class="form-group">
                                                    <label>Search</label>
                                                    <input type='text' name="search_keyword" class="form-control"
                                                        placeholder="Search by name, email, mobile..." />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mt-2">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-sm bg-gradient-danger"
                                                    id="btn_clear">Clear
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-sm bg-gradient-info float-right"
                                                    id="btn_filter">
                                                    <i class="fa fa-filter m-r-5"></i> Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        @include('backend.common.message')
                    </div>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-body p-0">
                        <table id="table" class="table m-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {

                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                $('.js-daterange-picker').daterangepicker({
                    showDropdowns: true,
                    autoUpdateInput: false,
                    applyClass: "btn-primary",
                    locale: {
                        format: 'DD-MM-YYYY',
                        separator: "-",
                        cancelLabel: 'Clear'
                    }
                }, function(start, end, label) {
                    console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                        'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                }).on('apply.daterangepicker', function(ev, picker) {
                    if (moment(picker.startDate.format('YYYY-MM-DD')).isSame(picker.endDate.format(
                            'YYYY-MM-DD'))) {
                        $(this).val(picker.startDate.format('DD-MM-YYYY'));
                    } else {
                        $(this).val(picker.startDate.format('DD-MM-YYYY') + '  -  ' + picker.endDate.format(
                            'DD-MM-YYYY'));
                    }

                    $('input[name="start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
                    $('input[name="end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
                }).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    $('input[name="start_date"]').val('');
                    $('input[name="end_date"]').val('');
                });

                // Search
                $('#btn_filter').click(function(e) {
                    table.draw(false);
                });

                // Clear
                $('#btn_clear').click(function(e) {
                    $('input[name="date"]').val('');
                    $('.js-daterange-picker').data('daterangepicker').setStartDate(moment().format(
                        'DD/MM/YYYY'));
                    $('.js-daterange-picker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
                    $('input[name="start_date"]').val('');
                    $('input[name="end_date"]').val('');


                    $('select[name="status"]').val('').trigger('change');
                    $('input[name="search_keyword"]').val('');

                    table.draw(false);
                });

                var table = $('#table').DataTable({
                    dom: '<"pl-2 pt-2 pr-2 pb-2" <"row" <"col-lg-6" l><"col-lg-3" f><"col-lg-3 text-right" B>> > rt <"border-top pl-2 pt-2 pr-2 pb-2 " <"row" <"col-lg-6" i><"col-lg-6" p>> >',
                    buttons: [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i>',
                        className: 'btn btn-sm btn-warning datatable-button',
                        exportOptions: {
                            orthogonal: 'export',
                            columns: [0, 1, 2, 3]
                        }
                    }, {
                        text: '<i class="fa fa-plus-circle"></i>',
                        className: 'btn btn-sm btn-success datatable-button',
                        action: function(e, dt, node, config) {
                            window.location.href = '{{ route('employee.create') }}';
                        }
                    }],
                    lengthChange: false,
                    searching: false,
                    info: true,
                    paging: true,
                    searchHighlight: false,
                    ordering: false,
                    autoWidth: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    stateSave: false,
                    deferRender: true,
                    pageLength: 10,
                    order: false,
                    columnDefs: [{
                            orderable: false,
                            targets: [0, 1, 2, 3, 4]
                        },
                        {
                            className: 'text-center',
                            targets: [0, 1, 2, 3, 4]
                        },
                        {
                            width: '30px',
                            targets: 4
                        }
                    ],
                    ajax: {
                        url: '{{ route('employee.index') }}',
                        dataType: 'json',
                        type: 'GET',
                        data: function(d) {
                            d.start_date = $('input[name="start_date"]').val();
                            d.end_date = $('input[name="end_date"]').val();
                            d.status = $('select[name="status"]').val();
                            d.search_keyword = $('input[name="search_keyword"]').val();
                        }

                    },
                    columns: [{
                        data: 'name'
                    }, {
                        data: 'email'
                    }, {
                        data: 'mobile'
                    }, {
                        data: 'status'
                    }, {
                        data: 'action'
                    }]
                });
            });
        </script>
    @endpush
@endsection

@extends('backend.layouts.main')
@section('title', 'Create')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Employee</a>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col">
                        @include('backend.common.message')
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-sm btn-secondary" href="{{ route('employee.index') }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <form action="{{ route('employee.store') }}" method="POST" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="first_name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="number">Mobile Number</label>
                                        <input type="number" class="form-control" id="number" name="number"
                                            value="{{ old('number') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control select2bs4" name="status" name="status">
                                            <option value="" hidden>---Select---</option>
                                            <option value="1" @if (old('status') == '1') selected @endif>Active
                                            </option>
                                            <option value="0" @if (old('status') == '0') selected @endif>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
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

            });
        </script>
    @endpush
@endsection

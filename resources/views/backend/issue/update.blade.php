@extends('backend.layouts.main')
@section('title', 'Edit')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('issue.index') }}">Issue</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('issue.index') }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                    </div>
                    <form action="{{ route('issue.update', $issue) }}" method="POST" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $issue->title }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="assigned_to">Assigned To</label>
                                        <select class="form-control select2bs4" name="assigned_to">
                                            <option value="" hidden>---Select---</option>
                                            @if (!empty($assigneds))
                                                @foreach ($assigneds as $assigned)
                                                    <option value="{{ $assigned->id }}"
                                                        @if ($issue->assigned_to == $assigned->id) selected @endif>
                                                        {{ $assigned->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="created_by">Created By</label>
                                        <select class="form-control select2bs4" name="created_by">
                                            <option value="" hidden>---Select---</option>
                                            @if (!empty($createds))
                                                @foreach ($createds as $created)
                                                    <option value="{{ $created->id }}"
                                                        @if ($issue->created_by == $created->id) selected @endif>
                                                        {{ $created->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control select2bs4" name="status" name="status">
                                            <option value="" hidden>---Select---</option>
                                            <option value="1" @if ($issue->status == '1') selected @endif>Panding
                                            </option>
                                            <option value="2" @if ($issue->status == '2') selected @endif>
                                                Complate
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Descraption</label>
                                        <textarea class="form-control" id="description" name="description" placeholder="Enter description here" rows="5"
                                            cols="5">{{ $issue->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
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

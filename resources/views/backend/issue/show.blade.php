@extends('backend.layouts.main')
@section('title', 'Show')
@section('sections')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Show</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('issue.index') }}">Issue</a>
                            </li>
                            <li class="breadcrumb-item active">Show</li>
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
                    <form action="javascript:void(0)" method="POST" autocomplete="off" enctype="multipart/form-data">

                        <div class="card-body">

                            <table class="table" style="width:100%">
                                <tr>
                                    <th>Question</th>
                                    <th>Answer</th>
                                </tr>

                                <tr>
                                    <td>Title</td>
                                    <td>{{ $issue->title ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td>Assigned To</td>
                                    <td>{{ $issue->assigned->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Created By</td>
                                    <td>{{ $issue->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    @if ($issue->status == 1)
                                        <td><span class="badge badge-warning p-1">Panding</span></td>
                                    @else
                                        <td><span class="badge badge-success p-1">Complate</span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{ $issue->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Created at</td>
                                    <td>{{ Carbon\Carbon::parse($issue->created_at)->format('d-M-Y') ?? '-' }}</td>
                                </tr>
                            </table>
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

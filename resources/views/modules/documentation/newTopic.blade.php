@extends('layouts.admin')

@section('title', 'New Topic')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">New Topic</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{ Session::get('status') }}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action='{{ url("/admin/documentation/new-topic") }}' method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label required">Topic name</label>
                                <input type="text" class="form-control" name="name" placeholder="Example : Firecek" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <label class="form-label required">Initial Version</label>
                                <input type="text" class="form-control" name="version_name" placeholder="Example : 1.0" required>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="form-label required">Public access</div>
                                <div>
                                    <select class="form-select" name="open_for_public" required>
                                        <option value=0 selected>Not allowed</option>
                                        <option value=1>Allowed</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <button type="submit" class="btn btn-primary">Next Step</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
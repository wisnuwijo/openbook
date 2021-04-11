@extends('layouts.admin')

@section('title', 'Documentation')

@section('content')
    <div class="container-xl">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title">Welcome</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Documentation</h3>
                        <p>Start your Documentation by creating new Topic. Here are detailed steps :</p>
                        <table>
                            <tr>
                                <td width="50px"><span class="avatar">1</span></td>
                                <td>Create Topic and Version</td>
                            </tr>
                            <tr>
                                <td width="50px"><span class="avatar">2</span></td>
                                <td>Create Documentation Breakdown</td>
                            </tr>
                            <tr>
                                <td width="50px"><span class="avatar">3</span></td>
                                <td>Create Post</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('title', 'Access denied')
@extends('layouts.error')
@section('css')
<style>
.empty-img {
    margin: 0 0 2rem;
    line-height: 1;
}

.empty-subtitle, .empty-title {
    margin: 0 0 .5rem;
}

.empty-title {
    font-size: 1.25rem;
    line-height: 1.4;
    font-weight: 600;
}
</style>
@endsection

@section('content')
<div class="container-xl d-flex flex-column justify-content-center">
    <div class="empty">
        <div class="empty-img">
            <img src="{{ url('img/access-denied.svg') }}" height="128" alt="">
        </div>
        <p class="empty-title">
            Access denied
        </p>
        <p class="empty-subtitle text-muted">
            @if ($exception->getMessage() != '')
                {{ $exception->getMessage() }}
            @else
                Contact your administrator to get access
            @endif
        </p>
        </div>
    </div>
</div>
@endsection
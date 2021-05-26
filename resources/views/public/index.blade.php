@extends('layouts.welcome')

@section('topic-list')
@if (count($topic_list) > 0)
    @foreach($topic_list as $tpcl)
        <div class="col-lg-4 col-md-7 col-sm-9">
            <div class="single-features mt-40">
                <div class="features-title-icon d-flex justify-content-between">
                    <h4 class="features-title"><a href="{{ url('/' . $tpcl->url) }}">{{ $tpcl->name }}</a></h4>
                    <div class="features-icon">
                        <i class="lni lni-book"></i>
                        <img class="shape" src="{{ asset('smash/images/f-shape-1.svg') }}" alt="Shape">
                    </div>
                </div>
                <div class="features-content">
                    {{--  <p class="text">Short description for the ones who look for something new. Short description for the ones who look for something new.</p>  --}}
                    <a class="features-btn" href="{{ url('/' . $tpcl->url) }}">VIEW DOCS</a>
                </div>
            </div> <!-- single features -->
        </div>  
    @endforeach
@endif
@endsection

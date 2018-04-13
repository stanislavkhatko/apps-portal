@extends('frontend.layouts.app')

@section('content')
    <div id="app" class="container portal_container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! $page->body !!}
            </div>
        </div>
    </div>
@endsection

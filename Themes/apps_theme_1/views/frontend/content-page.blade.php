@extends('frontend.layouts.app')

@section('content')
    <div class="app-content-page">
        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/{!! $item->download['link'] !!}?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
@endsection
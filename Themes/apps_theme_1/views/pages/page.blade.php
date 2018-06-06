@extends('pages.index')

@section('title', $page->title)

@section('content')
    <div class="app-page">
        {!! $page->body !!}
    </div>
@endsection
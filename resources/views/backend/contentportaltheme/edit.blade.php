@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <portal-theme-form :themes_="{{ $themes }}" :portal="{{ $contentPortal }}"></portal-theme-form>

        </div>
    </div>
@endsection

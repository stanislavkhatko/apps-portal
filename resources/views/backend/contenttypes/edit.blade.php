@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <content-type-form
                    :content-type_="{{ $contentType }}"
            ></content-type-form>

        </div>
    </div>
@endsection
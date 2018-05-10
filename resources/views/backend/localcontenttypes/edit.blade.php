@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <local-content-type-form
                    :content-type_="{{ $localContentType }}"
                    :languages="{{ \App\Models\Language::all(['code as value', 'name as label']) }}"
            ></local-content-type-form>

        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <local-content-type-form
                    :languages="{{ \App\Models\Language::all(['code as value', 'name as label']) }}"
            ></content-type-form>

        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <translation-form
                    :languages="{{ \App\Models\Language::all(['code as value', 'name as label']) }}"
                    :translations_="{{ $items }}">
            </translation-form>

        </div>
    </div>
@endsection
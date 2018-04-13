@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <portal-form
                    :local-content-types="{{ \App\Models\LocalContentType::all(['id as value', 'label', 'name']) }}"
                    :languages="{{ \App\Models\Language::all(['code as value', 'name as label']) }}"
            ></portal-form>

        </div>
    </div>
@endsection

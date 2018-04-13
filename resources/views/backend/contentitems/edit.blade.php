@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <content-item-form
                    :content-types="{{ \App\Models\ContentType::all(['id as value', 'label', 'provider']) }}"
                    :languages="{{ \App\Models\Language::all(['code as value', 'name as label']) }}"
                    :item="{{ $item }}"></content-item-form>

        </div>
    </div>
@endsection
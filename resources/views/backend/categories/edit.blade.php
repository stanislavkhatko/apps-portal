@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <category-form
                    :content-types="{{ \App\Models\ContentType::all(['id as value', 'label', 'provider']) }}"
                    :category_="{{ $category }}">

                </content-item-form>

        </div>
    </div>
@endsection
@extends('frontend.layouts.app')

@section('content')

    <div id="app" class="portal_container">
        <div class="category_wrapper">
            <div class="detail_header">
                <a class="link_back" href="/">
                    < @lang('portal.back')
                </a>

                <h3>
                    @lang('portal.category'): {{ $localCategory->label }}
                </h3>

                <div style="clear:both"></div>
            </div>

            @foreach ($localCategory->contentItems()->orderBy('rating', 'desc')->take(50)->get() as $app)
                @include('frontend.contentitems.contentitem', ['item'=> $app])
            @endforeach

            <div style="clear:both"></div>
        </div>
    </div>

@endsection

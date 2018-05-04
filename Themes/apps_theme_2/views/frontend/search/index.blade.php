@extends('frontend.layouts.app')

@section('content')

    <div class="portal_container">
        <div class="category_wrapper">
            <div class="detail_header">
                <a class="link_back" href="/">
                    < @lang('portal.back')
                </a>

                <h3>
                    @lang('portal.search'): {{ $search }}
                </h3>

                <div style="clear:both"></div>
            </div>

            @foreach ($items as $item)
                @include('frontend.contentitems.contentitem', ['item'=> $item])
            @endforeach

            <div style="clear:both"></div>
        </div>
    </div>

@endsection

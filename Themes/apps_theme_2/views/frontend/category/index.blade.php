@extends('frontend.layouts.app')

@section('content')

    <div id="app" class="container portal_container">

        <div class="category_wrapper">

            <div class="detail_header">
                <a class="link_back" href="/">
                    < @lang('portal.back')
                </a>
                <!-- detail_title_back -->

                <h3>
                    @lang('portal.category'): {{ $localCategory->label }}
                </h3>
                <!-- detail_title -->

                <div style="clear:both"></div>
            </div>
            <!-- detail_header -->

            @foreach ($localCategory->contentItems->take(50) as $app)
                @include('frontend.contentitems.contentitem', ['item'=> $app])
            @endforeach

            <div style="clear:both"></div>
        </div>
        <!-- category_wrapper -->

    </div>
    <!-- container -->

@endsection

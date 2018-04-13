@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

                @include('backend.menu')

            <div class="col-xs-12 app-content">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div>Downloads</div>                      
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body">

                        <div class="filter_wrapper">

                            <form method="GET" action="{{ route('downloads.index') }}" role="form" >

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search on MSISDN, subscription id, item,..." name="search" value="{{ Request::get('search') }}" autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if (Request::get('search'))                             
                                <a href="{{ route('downloads.index') }}" class="search_reset">
                                    {{ number_format($items->total()) }} results for <strong>{{ Request::get('search') }}</strong> <i class="fa fa-times-circle" aria-hidden="true"></i>
                                </a> 
                            @else
                                <div>
                                    {{ number_format($items->total()) }} results
                                </div>
                            @endif

                        </div>
                        <!-- filter_wrapper -->

                        @if (count($items) > 0)
                            <div class="table_wrapper">
                                <table class="table table-hover table-borderless m-b-none">
                                    <thead>
                                        <tr>
                                            <th>Subscr.ID</th>
                                            <th>MSISDN</th>
                                            <th colspan="2">Content item</th> 
                                            <th>Provider</th>
                                            <th>Content type</th>
                                            <th>Category</th>
                                            <th>Downloaded</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->subscription_id }}
                                                </td>
                                                <td>
                                                    {{ $item->msisdn }}
                                                </td>
                                                <td class="icon_small_header">
                                                    <img src="{{ $item->contentItem->preview }}" class="img-responsive" />
                                                </td>
                                                <td style="width: 320px;">
                                                    <strong>{{ $item->contentItem->title }}</strong>
                                                    <div class="description">
                                                        {!! $item->contentItem->shortDescription !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $item->contentItem->provider }}
                                                </td>
                                                <td>
                                                    {{ $item->contentItem->category->contentType->label }}
                                                </td>
                                                <td>
                                                    {{ $item->contentItem->category->label }}
                                                </td>
                                                <td>
                                                    {{ $item->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- table_wrapper -->
                        @endif

                        <div class="pagination_wrapper">
                            {{ $items->appends(request()->input())->links() }}
                        </div>
                        <!-- pagination_wrapper -->                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

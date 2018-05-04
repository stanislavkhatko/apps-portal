@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <div class="col-xs-12 app-content">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div>Content items</div>
                        <div class="panel_bttn">
                            <a class="btn btn-primary" href="{{ route('content-items.create') }}">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body">

                        <div class="filter_wrapper">

                            <form method="GET" action="{{ route('content-items.index') }}" role="form">
                                <div class="form-group">
                                    <select class="form-control" name="provider" onchange="this.form.submit()">
                                        <option value="" selected>All providers</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->provider }}" {{ (Request::get("provider") == $provider->provider ? "selected" : "") }}>
                                                {{ ucwords($provider->provider) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="contenttype" onchange="this.form.submit()">
                                        <option value="" selected>All content types</option>
                                        @foreach ($contenttypes as $contentType)
                                            <option value="{{ $contentType->id }}" {{ (Request::get("contenttype") == $contentType->id ? "selected" : "") }}>
                                                {{ $contentType->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="category" onchange="this.form.submit()">
                                        <option value="" selected>All categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ (Request::get("category") == $category->id ? "selected" : "") }}>
                                                {{ $category->label }} - (Content
                                                type: {{ $category->contentType->label }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="category_group" onchange="this.form.submit()">
                                        <option value="" selected>Group by all categories</option>
                                        @foreach ($categories->groupBy('label') as $category)
                                            <option value="{{ $category[0]->label }}" {{ (Request::get("category_group") == $category[0]->label ? "selected" : "") }}>
                                                {{ $category[0]->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--  <div class="form-group">
                                     <select class="form-control" name="device" onchange="this.form.submit()">
                                         <option selected disabled>Select device...</option>
                                         <option value="">All</option>
                                         <option value="android" {{ (Request::get("device") == "android" ? "selected" : "") }}>Android</option>
                                         <option value="nonandroid" {{ (Request::get("device") == "nonandroid" ? "selected" : "") }}>Non Android</option>
                                     </select>
                                 </div> --}}

                                <hr>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search title/remote id..."
                                               name="search" value="{{ Request::get('search') }}" autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
                                                        class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if (Request::get('search'))
                                <a href="{{ route('content-items.index') }}" class="search_reset">
                                    {{ number_format($items->total()) }} results for
                                    <strong>{{ Request::get('search') }}</strong> <i class="fa fa-times-circle"
                                                                                     aria-hidden="true"></i>
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
                                        <th class="icon_small_header">Icon</th>
                                        <th style="width:320px;">Info</th>
                                        <th>Provider</th>
                                        <th>Content type</th>
                                        <th>Category</th>
                                        <th>Device</th>
                                        <th>Updated</th>
                                        <th style="width: 100px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item->preview }}" class="img-responsive"/>
                                            </td>
                                            <td>
                                                <strong>{{ $item->title }}</strong>
                                                <div class="description">
                                                    {!! $item->shortDescription !!}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->provider }}
                                                @if ($item->category && $item->category->remote_id)
                                                    <br>(r.id: {{ $item->remote_id }})
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->category)
                                                    {{ $item->category->contenttype->label }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->category)
                                                    {{ $item->category->label }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->compatibility['os'])
                                                    {{ $item->compatibility['os'] }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->updated_at }}
                                            </td>
                                            <td class="text-right">

                                                <a href="{{ route('content-items.edit', $item) }}"
                                                   class="btn btn-default">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @if ($item->remote_id != 0)
                                                    <a href="#"
                                                       class="btn btn-danger"
                                                       style="opacity: 0.2"
                                                       data-toggle="tooltip"
                                                       title="Content items belonging to external providers (not system providers) can not be deleted">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('content-items.destroy', $item->id) }}"
                                                       class="btn btn-danger"
                                                       data-method="delete"
                                                       data-token="{{ csrf_token() }}"
                                                       data-title="Delete content item"
                                                       data-confirm="Are you sure you want to delete content item <strong>{{ $item->title }}</strong>?">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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

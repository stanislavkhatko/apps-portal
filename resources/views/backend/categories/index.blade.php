@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <div class="col-xs-12 app-content">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div>Categories</div>
                        <div class="panel_bttn">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body">

                        <div class="filter_wrapper">

                            <form method="GET" action="{{ route('categories.index') }}" role="form">

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

                                <hr>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search label..."
                                               name="search" value="{{ Request::get('search') }}" autocomplete="off">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
                                                        class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if (Request::get('search'))
                                <a href="{{ route('categories.index') }}" class="search_reset">
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
                                        <th>Label</th>
                                        <th>Content type</th>
                                        <th>Content items</th>
                                        <th>Adult</th>
                                        <th>Provider</th>
                                        <th>Updated</th>
                                        <th style="width: 100px;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                {{ $item->label }}
                                            </td>
                                            <td>
                                                @if ($item->contentType)
                                                    {{ $item->contentType->label }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('content-items.index', ['category' => $item->id]) }}">
                                                    {{ $item->contentItems()->count() }}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($item->adult == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->contentType)
                                                    {{ $item->contentType->provider }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->updated_at }}
                                            </td>
                                            <td class="text-right">

                                                <a href="{{ route('categories.edit', $item) }}" class="btn btn-default">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @if ($item->remote_id != 0)
                                                    <a href="#"
                                                       class="btn btn-danger"
                                                       style="opacity: 0.2"
                                                       data-toggle="tooltip"
                                                       title="Categories belonging to external providers (not system providers) can not be deleted">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('categories.destroy', $item->id) }}"
                                                       class="btn btn-danger"
                                                       data-method="delete"
                                                       data-token="{{ csrf_token() }}"
                                                       data-title="Delete category"
                                                       data-confirm="Are you sure you want to delete the category <strong>{{ $item->label }}</strong>?">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                @endif
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

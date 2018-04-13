@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row app">

            @include('backend.menu')

            <div class="col-xs-12 app-content">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div>Portals</div>  

                        <div class="panel_bttn">
                            <a href="{{ route('portal.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                            </a>   
                        </div>                       
                    </div>
                    <!-- panel-heading -->

                    <div class="panel-body">
                        @if ($portals->count())
                        <div class="table_wrapper">
                        <table class="table table-borderless m-b-none">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Domain</th>
                                    <th>Content types</th>
                                    <th>Categories</th>
                                    <th>Content items</th>
                                    <th>Last updated</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($portals as $portal)
                                <tr>
                                    <td>
                                        <strong>{{ $portal->title }}</strong>
                                    </td>
                                    <td>
                                        <a href="http://{{ $portal->domain }}" target="_blank">
                                            {{ $portal->domain }}
                                        </a>                                        
                                    </td>
                                    <td>
                                        {{ $portal->localContentTypes->count() }}
                                    </td>
                                    <td>
                                        <?php $counter = 0; ?>
                                        @if ($portal->localContentTypes)
                                            @foreach ($portal->localContentTypes as $contentType)
                                                <?php $counter = $counter + $contentType->localCategories->count(); ?>
                                            @endforeach
                                        @endif
                                        {{ $counter }}
                                    </td>
                                    <td>
                                        / {{-- {{ $portal->contentItems->count() }} --}}
                                    </td>
                                    <td>
                                        {{ $portal->updated_at }}
                                    </td>
                                    <td>
                                        {{ $portal->created_at }}
                                    </td>

                                    <td class="text-right">
                                        <a href="{{ route('portal.edit', $portal) }}" class="btn btn-default"> 
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('portal-theme.edit', $portal->id) }}" class="btn btn-default margin_right_10"> 
                                            <i class="fa fa-eyedropper"></i>
                                        </a>                             
                                        <a href="{{ route('portal.destroy', $portal->id) }}"
                                           class="btn btn-danger"
                                           data-method="delete"
                                           data-token="{{ csrf_token() }}"
                                           data-title="Delete portal"
                                           data-confirm="Are you sure you want to delete the portal `{{ $portal->title }}`?"
                                        >
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>

                                </tr><!--v-for-end-->
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                        @else
                            No content portals configured.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

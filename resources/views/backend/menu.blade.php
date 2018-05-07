<div class="app-menu collapse in" id="app-menu-collapse">

    <div class="panel panel-default panel-flush">
        <div class="panel-heading">
            <div>Portal overview</div>
        </div>

        <div class="panel-body padding_zero">
            <div class="spark-settings-tabs">
                <ul class="nav spark-settings-stacked-tabs" role="tablist">
                    <li role="presentation">
                        <a href="{{ route('portal.index') }}" class="{{  (Request::segment(2) == 'portal' || Request::segment(2) == 'portal-theme') ? 'active' : ''  }}">
                            Portals
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-flush">
        <div class="panel-heading">
            <div>Portal Content</div>
        </div>

        <div class="panel-body padding_zero">
            <div class="spark-settings-tabs">
                <ul class="nav spark-settings-stacked-tabs" role="tablist">
                    <li role="presentation">
                        <a href="{{ route('local-content-types.index') }}" class="{{  Request::segment(2) == 'local-content-types' ? 'active' : ''  }}">
                            Portal Content types
                        </a>
                        <a href="{{ route('translations.index') }}" class="{{  Request::segment(2) == 'translations' ? 'active' : ''  }}">
                            Translations
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="panel panel-default panel-flush">
        <div class="panel-heading">
            <div>Downloads overview</div>
        </div>

        <div class="panel-body padding_zero">
            <div class="spark-settings-tabs">
                <ul class="nav spark-settings-stacked-tabs" role="tablist">
                    <li role="presentation">
                        <a href="{{ route('downloads.index') }}" class="{{  Request::segment(2) == 'downloads' ? 'active' : ''  }}">
                            Downloads
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr>

    <div class="panel panel-default panel-flush">
        <div class="panel-heading">
            <div>Provider Content overview</div>
        </div>

        <div class="panel-body padding_zero">
            <div class="spark-settings-tabs">
                <ul class="nav spark-settings-stacked-tabs" role="tablist">
                    <li role="presentation">
                        <a href="{{ route('content-types.index') }}" class="{{  Request::segment(2) == 'content-types' ? 'active' : ''  }}">
                            Content types
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ route('categories.index') }}" class="{{  Request::segment(2) == 'categories' ? 'active' : ''  }}">
                            Categories
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ route('content-items.index') }}" class="{{  Request::segment(2) == 'content-items' ? 'active' : ''  }}">
                            Content items
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

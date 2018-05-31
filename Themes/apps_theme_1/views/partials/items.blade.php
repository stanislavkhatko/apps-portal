@foreach($items as $item)

    <a href="{{ route('view.contentitem', [$item]) }}" class="app-category-item">

        <div class="app-category-item--main">
            <img src="{{ '/cache/fit185'. $item->preview}}" alt="{{ $item->title }}" class="app-category-item__thumb">

            <div class="app-category-item__title">
                {{ $item->title }}
            </div>
        </div>

        <div class="app-category-item--details">

            <div class="app-category-item__category">
                {{ $item->localCategory->first()->label }}
            </div>

            <div class="app-category-item__rating">
                @for($i = 0; $i < 5; $i++)
                    <span class="{{ $i < $item->rating ? 'active' : '' }}">☆</span>
                @endfor
            </div>

            <div class="app-category-item__price">
                @lang('portal.free')
            </div>

        </div>

    </a>

@endforeach
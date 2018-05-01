<!-- Item -->
<a href="{{ route('view.contentitem', [$item]) }}" class="app-category-item">

    <img src="{{ ($item->type == 'flash') ? '/img/musica2.png' : $item->type == 'mp3' ? '/img/musica.png' : $item->preview}}"
         alt="" class="app-category-item__thumb">

    <div class="app-category-item-type">
        @if($item->category->icon)
            <img src="{{ $item->category->icon }}"
                 alt="{{ $item->category->label }}"
                 class="app-category-items-type__thumb">
        @endif
        {{ $item->category->label }}
    </div>

    @include('frontend.partials.rating', $item)

    <div class="app-category-item__title">
        {{ $item->title }}
    </div>

</a>
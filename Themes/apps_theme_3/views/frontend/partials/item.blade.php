<a href="{{ isset($localContentType) && isset($localCategory) ? route('view.fullcontentitem', ['localContentType' => $localContentType, 'localCategory' => $localContentType->localCategories->first(),  'contentItem'=> $item]) : route('view.contentitem', ['contentItem'=> $item]) }}"
   class="item">

    <div class="img_block" style="background-image: url('{{ $item->preview }}')"></div>

    <div class="title">
        {{ $item->title }}
    </div>
    <!-- title -->
</a>
<!-- item -->
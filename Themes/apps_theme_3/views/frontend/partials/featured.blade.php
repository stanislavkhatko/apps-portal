<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">

    <!-- Indicators -->
    <ol class="carousel-indicators">

        @foreach($items as $item)
            @if ($item->pivot->visible == 1)

                <li data-target="#myCarousel" data-slide-to="{{ $loop->index }}"
                    class="@if ($loop->first) active @endif"></li>

            @endif
        @endforeach
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

        @foreach($items as $item)
            @if ($item->pivot->visible == 1)
                <a href="{{ route('view.contentitem', ['contentItem'=> $item]) }}"
                   class="item @if ($loop->first) active @endif">
                    <img src="{{ asset("storage/{$item->pivot->banner}") }}" alt="Chania">
                    <div class="carousel-caption">
                        <h3>{{ $item->title }}</h3>
                        <div class="play_bttn">
                            @lang('portal.play')
                        </div>
                    </div>
                </a>
            @endif
        @endforeach

    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>
<!-- myCarousel -->

<div style="clear: both;"></div>
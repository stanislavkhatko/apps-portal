<div class="app-category-item__rating">
    @for($i = 0; $i < 5; $i++)
        <span class="glyphicon glyphicon-star{{ $i < $item->rating ? '' : '-empty' }}" aria-hidden="true"></span>
    @endfor
</div>
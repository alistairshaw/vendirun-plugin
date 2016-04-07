<div class="buttons">
    @foreach ($productButtons as $button)
        @include('vendirun::product.partials.buttons.' . $button)
    @endforeach
</div>
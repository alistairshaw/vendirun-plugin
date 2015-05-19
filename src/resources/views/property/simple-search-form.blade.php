<form method="post" action="{{ route('vendirun.propertySearch') }}">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
    <div class="form-group">
        <label class="sr-only">Property Search</label>
        <input type="text" class="form-control" name="search_string" placeholder="e.g. Marbella, Country Property, 3 Bedroom Villa">
    </div>
    <button type="submit" class="btn btn-default">Start your search now</button>
</form>
<form method="post" action="{{ route('vendirun.propertySearch') }}" class="search-box">
    <div class="form-group">
        <label class="sr-only">Property Search</label>
        <input type="text" class="form-control" name="search_string" placeholder="e.g. 2 Bedroom Apartment in Marbella">
    </div>
    <div class="form-group">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <button type="submit" class="btn btn-default">Start your search now</button>
    </div>
</form>
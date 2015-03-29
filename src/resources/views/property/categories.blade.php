<div class="property-categories" id="category-search">
    <div class="container">
        <div class="row">
            <?php  $count = 0; ?>
            <?php  $secondCounter = 0; ?>
            <?php  $thirdCounter = 0; ?>
            @foreach($categories as $category)
                <?php $thirdCounter++ ?>
                @if($count < 2)
                    <?php $count++;?>
                    <div class="col-sm-6 clearfix">
                        <div class="category-search-item">
                            <div class="col text-col-left">
                                <div class="arrow arrow-right">
                                    <i class="fa fa-caret-right fa-4x"></i>
                                </div>
                                <div class="copy">
                                    <h2>{{ $category->category_name }}</h2>
                                    <p>{{ $category->category_description }}</p>
                                    <form method="post" action="{{ route('vendirun.propertySearch') }}">
                                        <input type="hidden" class="form-control" value="{{ $category->id }}" name="propertytype" >
                                        <button type="submit" class="btn btn-default">View Properties</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col col-right">
                                <img src="{{ $category->primary_image }}" class="img-responsive">
                            </div>
                        </div>
                    </div>
                @else
                    <?php $secondCounter++; ?>
                    <div class="col-sm-6 clearfix">
                        <div class="category-search-item">
                            <div class="col">
                                <img src="{{ $category->primary_image }}" class="img-responsive">
                            </div>
                            <div class="col text-col">
                                <div class="arrow arrow-left">
                                    <i class="fa fa-caret-left fa-4x"></i>
                                </div>
                                <div class="copy">
                                    <h2>{{ $category->category_name }}</h2>
                                    <p>{{ $category->category_description }}</p>
                                    <form method="post" action="{{ route('vendirun.propertySearch') }}">
                                        <input type="hidden" class="form-control" value="{{ $category->id }}" name="propertytype" >
                                        <button type="submit" class="btn btn-default">View Properties</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($thirdCounter == 2)
                    <?php $thirdCounter = 0; ?>
                    <div class="clearfix"></div>
                @endif
                @if($count == 2 && $secondCounter == 2)
                    <?php $count = $secondCounter = 0; ?>
                @endif
            @endforeach
        </div>
    </div>
</div>
<div class="property-category-list">
    @if (isset($category->category_name) && $category->category_name)
        <div class="back-button-container">
            <div class="row">
                <div class="col-sm-12">
                    @if ($category->parent)
                        <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($category->parent->category_name)]) }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> {{ trans('vendirun::property.backTo') }} {{ $category->parent->category_name }}
                        </a>
                    @else
                        <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', ['']) }}" class="btn btn-default"><i class="fa fa-angle-double-left"></i> {{ trans('vendirun::property.backToCategories') }}</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="image-container img-thumbnail">
                    <div class="{{ count($category->images) > 1 ? 'property-slide-show' : '' }}">
                        @foreach($category->images as $image)
                            <img src="{{ $image->mediumrect }}" class="img-responsive">
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <h1>{{ $category->category_name }}</h1>

                <p>{{ $category->category_description }}</p>

                <a class="btn btn-default" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}/?propertytype={{ $category->id }}">{{ trans('vendirun::property.viewProperties') }}</a>
            </div>
        </div>
        <hr>
    @endif

    @if ($element_options['layout'] == '2 columns' || $element_options['layout'] == '3 columns' || $element_options['layout'] == '4 columns')
        <div class="row">
            @foreach($category->sub_categories as $subCategory)
                <div class="col-sm-6 col-md-{{ $element_options['col_md'] }}">
                    <div class="thumbnail">
                        @if ($element_options['show_images'] == 'Yes')
                            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">
                                <img src="{{ reset($subCategory->images)->mediumrect }}" class="img-responsive">
                            </a>
                        @endif

                        <div class="caption">
                            <h3 id="thumbnail-label">{{ $subCategory->category_name }}</h3>

                            <p>{{ substr($subCategory->category_description, 0, 300) }}{{ (strlen($subCategory->category_description) > 300) ? '...' : '' }}</p>
                        </div>

                        <div class="buttons">
                            <a class="btn btn-default" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}/?propertytype={{ $subCategory->id }}">{{ trans('vendirun::property.viewProperties') }}</a>
                            <a class="btn btn-primary" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">{{ trans('vendirun::property.viewCategory') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @elseif ($element_options['layout'] == 'Staggered')
        <div class="property-categories">
            <div class="row">
                <?php  $count = 0; ?>
                @foreach($category->sub_categories as $subCategory)
                    <?php $count++;?>
                    @if($count > 2)
                        <?php if ($count == 4) $count = 0; ?>
                        <div class="col-sm-6 clearfix">
                            <div class="category-search-item">
                                <div class="col text-col-left">
                                    <div class="arrow arrow-right">
                                        <i class="fa fa-caret-right fa-4x"></i>
                                    </div>
                                    <div class="copy">
                                        <h2>{{ $subCategory->category_name }}</h2>

                                        <p>{{ $subCategory->category_description }}</p>

                                        <a class="btn btn-default" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}/?propertytype={{ $subCategory->id }}">{{ trans('vendirun::property.viewProperties') }}</a>
                                        <a class="btn btn-primary" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">{{ trans('vendirun::property.viewCategory') }}</a>
                                    </div>
                                </div>
                                <div class="col col-right">
                                    <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">
                                        <img src="{{ reset($subCategory->images)->mediumsq }}" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6 clearfix">
                            <div class="category-search-item">
                                <div class="col">
                                    <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">
                                        <img src="{{ reset($subCategory->images)->mediumsq }}" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col text-col">
                                    <div class="arrow arrow-left">
                                        <i class="fa fa-caret-left fa-4x"></i>
                                    </div>
                                    <div class="copy">
                                        <h2>{{ $subCategory->category_name }}</h2>

                                        <p>{{ $subCategory->category_description }}</p>

                                        <a class="btn btn-default" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}/?propertytype={{ $subCategory->id }}">{{ trans('vendirun::property.viewProperties') }}</a>
                                        <a class="btn btn-primary" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">{{ trans('vendirun::property.viewCategory') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="property-categories">
            @foreach($category->sub_categories as $subCategory)
                <div class="property-category-list-item clearfix">
                    @if ($element_options['show_images'] == 'Yes')
                        <div class="image-container">
                            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">
                                <img src="{{ reset($subCategory->images)->mediumrect }}" class="img-responsive">
                            </a>
                        </div>
                    @endif
                    <div class="details">
                        <h2>{{ $subCategory->category_name }}</h2>

                        <p>{{ $subCategory->category_description }}</p>

                        <div class="buttons">
                            <a class="btn btn-default" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.propertySearch') }}/?propertytype={{  $subCategory->id }}">{{ trans('vendirun::property.viewProperties') }}</a>
                            <a class="btn btn-primary" href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.category', [urlencode($subCategory->link_name)]) }}">{{ trans('vendirun::property.viewCategory') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
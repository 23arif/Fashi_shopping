@if(count($categories))
    <div class="filter-widget">
        <h4 class="fw-title">Categories</h4>
        <ul class="filter-catagories">
            @foreach($categories as $category)
                <li><a href="/shop/category/{{$category->slug}}">{{$category->category_name}}</a></li>
            @endforeach
        </ul>
    </div>
@endif

@if(count($brands))
    <div class="filter-widget">
        <h4 class="fw-title">Brand</h4>
        <div class="fw-brand-check">
            <div class="bc-item">
                <ul class="filter-catagories">
                    @foreach($brands as $brand)
                        <li><a href="/shop/brand/{{$brand->slug}}">{{$brand->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<div class="filter-widget">
    <h4 class="fw-title">Price</h4>
    <form action="{{route('priceFilter')}}" method="post" id="priceFilter">
        @csrf
        <div class="filter-range-wrap">
            <div class="range-slider">
                <div class="price-input">
                    <input type="text" id="minamount" name="minamount">
                    <input type="text" id="maxamount" name="maxamount">
                </div>
            </div>
            <div
                class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                data-min="1" data-max="{{$maxPrice}}">
                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
        </div>
        <button class="btn filter-btn">Filter</button>
    </form>
</div>
{{--Colors--}}
@if(count($colors))
    <div class="filter-widget">
        <h4 class="fw-title">Color</h4>
        <div class="fw-color-choose">
            @foreach($colors as $color)
                <div class="cs-item">
                    <a href="{{route('prColor',['color'=>$color])}}">
                        <label style="background:{{'#'.$color}}"></label>
                    </a>
                </div>
            @endforeach
        </div>
    </div><br>
@endif
{{--Sizes--}}
@if(count($sizes))
    <div class="filter-widget">
        <h4 class="fw-title">Size</h4>
        <div class="fw-size-choose">
            @foreach($sizes as $size)
                <div class="sc-item">
                    <input type="radio" id="{{$size}}-size" onclick="getSize('{{$size}}')">
                    <label for="{{$size}}-size">{{$size}}</label>
                </div>
            @endforeach
        </div>
    </div>
@endif
{{--Tags--}}
@if(count($tags))
    <div class="filter-widget">
        <h4 class="fw-title">Tags</h4>
        <div class="fw-tags">
            @foreach($tags as $tag)
                <a href="/shop/tags/{{$tag}}">{{ucfirst(strtolower($tag))}}</a>
            @endforeach
        </div>
    </div>
@endif
<script>
    function getSize($slug) {
        var slug = $slug;
        window.location.href = '/shop/size/' + slug;
    }
</script>

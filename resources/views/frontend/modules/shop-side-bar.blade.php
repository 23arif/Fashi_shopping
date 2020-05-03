<div class="filter-widget">
    <h4 class="fw-title">Categories</h4>
    <ul class="filter-catagories">
        @foreach($categories as $category)
            <li><a href="/shop/category/{{$category->slug}}">{{$category->category_name}}</a></li>
        @endforeach
    </ul>
</div>
<div class="filter-widget">
    <h4 class="fw-title">Brand</h4>
    <div class="fw-brand-check">

        @foreach($brands as $brand)
            <div class="bc-item">
                <label for="bc-calvin">
                    {{$brand->name}}
                    <input type="checkbox" id="{{$brand->slug}}">
                    <span class="checkmark"></span>
                </label>
            </div>
        @endforeach

    </div>
</div>
<div class="filter-widget">
    <h4 class="fw-title">Price</h4>
    <div class="filter-range-wrap">
        <div class="range-slider">
            <div class="price-input">
                <input type="text" id="minamount">
                <input type="text" id="maxamount">
            </div>
        </div>
        <div
            class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
            data-min="33" data-max="98">
            <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
        </div>
    </div>
    <a href="#" class="filter-btn">Filter</a>
</div>
{{--Colors--}}
<div class="filter-widget">
    <h4 class="fw-title">Color</h4>
    <div class="fw-color-choose">
        <div class="cs-item">
            <input type="radio" id="cs-black">
            <label class="cs-black" for="cs-black">Black</label>
        </div>
        <div class="cs-item">
            <input type="radio" id="cs-violet">
            <label class="cs-violet" for="cs-violet">Violet</label>
        </div>
        <div class="cs-item">
            <input type="radio" id="cs-blue">
            <label class="cs-blue" for="cs-blue">Blue</label>
        </div>
        <div class="cs-item">
            <input type="radio" id="cs-yellow">
            <label class="cs-yellow" for="cs-yellow">Yellow</label>
        </div>
        <div class="cs-item">
            <input type="radio" id="cs-red">
            <label class="cs-red" for="cs-red">Red</label>
        </div>
        <div class="cs-item">
            <input type="radio" id="cs-green">
            <label class="cs-green" for="cs-green">Green</label>
        </div>
    </div>
</div>
{{--/Colors--}}

{{--Sizes--}}
<div class="filter-widget">
    <h4 class="fw-title">Size</h4>
    <div class="fw-size-choose">
        @foreach($sizes->sortBy('id') as $size)
            <div class="sc-item">
                <input type="radio" id="{{$size->slug}}-size" onclick="getSize('{{$size->slug}}')">
                <label for="{{$size->slug}}-size">{{$size->size}}</label>
            </div>
        @endforeach
    </div>
</div>
{{--/Sizes--}}

<div class="filter-widget">
    <h4 class="fw-title">Tags</h4>
    <div class="fw-tags">
        @foreach(\App\Product::pluck('pr_tags') as $tags)
            @foreach(explode(',',$tags) as $tag)
                <a href="/shop/tags/{{$tag}}">{{$tag}}</a>
            @endforeach
        @endforeach
    </div>
</div>
<script>
    function getSize($slug) {
        var slug = $slug;
                window.location.href = '/shop/size/' + slug;
    }
</script>

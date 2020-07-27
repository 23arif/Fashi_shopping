<div class="blog-sidebar">
    <div class="search-form">
        <h4>Search</h4>
        <form method="get" action="{{route('blogSearch')}}" id="searchForm">
            <input type="text" name="result" placeholder="Search . . .  ">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="blog-catagory">
        <h4>Categories</h4>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="/blog/{{$category->slug}}">{{$category->name}}</a>
                </li>
                @foreach($category->child as $secondary_category)
                    <li>
                        <a href="/blog/{{$category->slug}}/{{$secondary_category->slug}}">{{$secondary_category->name}}</a>
                    </li>
                    @foreach($secondary_category->child as $double_sec_category)
                        <li>
                            <a href="/blog/{{$category->slug}}/{{$secondary_category->slug}}/{{$double_sec_category->slug}}">{{$double_sec_category->name}}</a>
                        </li>
                    @endforeach
                @endforeach
            @endforeach

        </ul>
    </div>
    <div class="recent-post">
        <h4>Recent Post</h4>
        <div class="recent-blog">
            @foreach($recentBlogs->take(3) as $blog)
                @foreach($photos = Storage::disk('uploads')->files('img/blog/'.$blog->slug) as $photo)
                @endforeach
                <a href="/blog/@if(isset($blog->parent))@php($primaryCategory=$blog->parent)@if(isset($primaryCategory->parent))@php($doubleprimaryCategory= $primaryCategory->parent)@if(isset($doubleprimaryCategory->parent)){{$doubleprimaryCategory->parent->slug}}/@endif{{$primaryCategory->parent->slug}}/@endif{{$blog->parent->slug}}/@endif{{$blog->slug}}"
                   class="rb-item">
                    <div class="rb-pic">
                        <img src="/uploads/{{$photo}}" alt="{{$blog->title}}">
                    </div>
                    <div class="rb-text">
                        <h6>{{$blog->title}}</h6>
                        <p>
                            <span>- {{$blog->created_at->formatLocalized('%d')}} {{$blog->created_at->formatLocalized('%b')}},{{$blog->created_at->formatLocalized('%Y')}}</span>
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="blog-tags">
        <h4>Product Tags</h4>
        <div class="tag-item">
                <a href="#">tags</a>
        </div>
    </div>
</div>

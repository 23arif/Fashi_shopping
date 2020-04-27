<div class="blog-sidebar">
    <div class="search-form">
        <h4>Search</h4>
        <form method="get" id="search">
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
            <a href="#" class="rb-item">
                <div class="rb-pic">
                    <img src="/frontend/img/blog/recent-1.jpg" alt="">
                    <img src="" alt="">
                </div>
                <div class="rb-text">
                    <h6>The Personality Trait That Makes...</h6>
                    <p>Fashion <span>- May 19, 2019</span></p>
                </div>
            </a>
            <a href="#" class="rb-item">
                <div class="rb-pic">
                    <img src="/frontend/img/blog/recent-2.jpg" alt="">
                </div>
                <div class="rb-text">
                    <h6>The Personality Trait That Makes...</h6>
                    <p>Fashion <span>- May 19, 2019</span></p>
                </div>
            </a>
            <a href="#" class="rb-item">
                <div class="rb-pic">
                    <img src="/frontend/img/blog/recent-3.jpg" alt="">
                </div>
                <div class="rb-text">
                    <h6>The Personality Trait That Makes...</h6>
                    <p>Fashion <span>- May 19, 2019</span></p>
                </div>
            </a>
            <a href="#" class="rb-item">
                <div class="rb-pic">
                    <img src="/frontend/img/blog/recent-4.jpg" alt="">
                </div>
                <div class="rb-text">
                    <h6>The Personality Trait That Makes...</h6>
                    <p>Fashion <span>- May 19, 2019</span></p>
                </div>
            </a>
        </div>
    </div>
    <div class="blog-tags">
        <h4>Product Tags</h4>
        <div class="tag-item">
            <a href="#">Towel</a>
            <a href="#">Shoes</a>
            <a href="#">Coat</a>
            <a href="#">Dresses</a>
            <a href="#">Trousers</a>
            <a href="#">Men's hats</a>
            <a href="#">Backpack</a>
        </div>
    </div>
</div>

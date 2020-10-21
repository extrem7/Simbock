@php /* @var $category \App\Models\Blog\Category */ @endphp
<div class="nav-article-links horizontal-scroll">
    <a href="{{route('frontend.articles.index')}}"
       class="nav-article-link {{$category===null?'active':''}}">All news</a>
    @foreach($categories as $category)
        <a href="{{route('frontend.articles.category',$category->slug)}}"
           class="nav-article-link {{$category->is_active?'active':''}}">{{ $category->name }}</a>
    @endforeach
</div>

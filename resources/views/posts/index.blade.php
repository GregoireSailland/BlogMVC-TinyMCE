@extends("sidebar")

@section('title')
    @if(isset($category))
        Category : {{ $category->name }}
    @elseif(isset($user))
        Author : {{ $user->name }}
    @else
        Blog
    @endif
    @if(request()->query('page') > 1)
        Page {{ request()->query('page') }}
    @endif
@endsection

@section("main")
    @if(0){{ dd($posts) }}@endif
    @if($posts)<p class="text-right">{{ $posts->count() }} Posts</p>@endif
    @foreach($posts as $post)
        <h2><a href="{{ route('posts.show', ['slug' => $post->slug]) }}">{{ $post->name }}</a></h2>
        <p>
            <small>     
                Category : <a href="{{ route('posts.category', ['slug' => $post->category->slug]) }}">{{ $post->category->name }}</a>
                by <a href="{{ route('posts.user', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                on {{ $post->created_at->format('M dS Y') }}
                @if($post->private) <b>private</b> @else <b>public</b> @endif
            </small>
        </p>
        <p>
            {{ $post->getExcerpt() }}
        </p>
        <p class="text-right">
            <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="btn btn-primary">Read more...</a>
        </p>
    @endforeach

    <div class="navigation">
        {{ $posts->links('vendor.pagination.bootstrap-4') }}
    </div>

@endsection
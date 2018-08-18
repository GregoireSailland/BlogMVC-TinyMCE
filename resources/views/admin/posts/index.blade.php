@extends('admin.layout')

@section('content')
    <h1>Manage posts</h1>

    <p>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Add a new post</a>
    </p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Publication date</th>
                <th>Actions</th>
                <th>Status</th>
                <th>Author</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td><a href="{{ route('posts.show', ['slug' => $post->slug]) }}">{{ $post->name }}</a></td>
                    <td>{{ $post->category->name }}</td>
                    <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @can('update',$post)
                            <a href="{{ route('admin.posts.edit', ['id' => $post->id]) }}" class="btn btn-primary">Edit</a>
                        @endcan
                         @can('delete',$post)
                            {!! Form::model($post, ['method' => 'DELETE', 'route' => ['admin.posts.destroy', $post], 'style' => 'display:inline;']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                    <td>
                       @if($post->private)
                        Private
                        @else
                        Public
                        @endif
                    </td>
                    <td>
                       <a href="{{ route('posts.user', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="navigation">
        {{ $posts->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection
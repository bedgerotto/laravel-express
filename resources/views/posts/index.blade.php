@extends('template')

@section('content')
    <h1>blog</h1>

    @foreach( $posts as $post )

        <h2>{{ $post->title }}</h2>
        <p>{{ $post->content }}</p>

        @if($post->comments)
            <h3>Comments: </h3>

            @foreach($post->comments as $comment)
                <b>Name: </b> {{$comment->name}} </br>
                <b>Comment: </b> {{$comment->comment}}
            @endforeach
        @endif

        <hr>

    @endforeach
@endsection

@extends('layouts.app')
@section('content')
<a href="/posts" class="btn btn-basic">Go Back</a>
    <h1>{{$post->title}}</h1>
    <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
    <br><br>
            <div class="card">
                <div class="card-body">
                    {!!$post->body !!}
                </div>
            </div>
    <hr>
     <small>written on {{ $post->created_at }} by {{$post->user->name}}<small>
    <hr>
    @if (!Auth::guest())
        @if (Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">edit</a>
            {!! Form::open(['action' => ['App\Http\controllers\PostsController@destroy',$post->id], 'method' => 'POST','class'=>'float-end']) !!}     
            {{Form::hidden('_method','DELETE')}}

            {{Form::submit('Delete',['class' =>'btn btn-danger'])}}
            {!! Form::close() !!}     
        @endif
          
    @endif
    
                 
            
@endsection

    

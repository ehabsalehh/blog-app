@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-primary"> Create Post</a>
                    <h3>Your Blog Post</h3>
                    @if (count($posts)>0)
                    
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            @foreach ($posts as $post)
                            <tbody>
                                <tr>
                                <td>{{$post->title}}</td>
                                <td>
                                    <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">edit</a>
                                </td>
                                <td>
                                        {!! Form::open(['action' => ['App\Http\controllers\PostsController@destroy',$post->id], 'method' => 'POST','class'=>'float-end']) !!}     
                                        {{Form::hidden('_method','DELETE')}}
                                    
                                        {{Form::submit('Delete',['class' =>'btn btn-danger'])}}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            </tbody>
                                
                            @endforeach
                            
                        </table>
                    @else
                        <p> You Have No Posts</p>    
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

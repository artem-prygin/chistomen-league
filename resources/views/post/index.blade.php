<?php

use App\Models\Post;

/**
 * @var $posts Post
 * @var $post Post
 */
?>

@extends('layouts.main')
@section('title', 'Посты')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show profile-alert" role="alert">
                <span>{{session('success')}}</span>
                <button class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(Route::currentRouteName() === 'posts-category' && !empty($posts[0]->category->name))
            <h4 style="margin-bottom: 30px">Посты категории "{{$posts[0]->category->name}}"</h4>
        @endif

        @if($posts && count($posts) > 0)
            <div class="row align-items-center">

                @foreach($posts as $post)
                    <div class="col-lg-6">
                        <div class="card post-card">
                            <h5 class="card-header">{{$post->title}}</h5>
                            <div class="card-body">
                                <p>
                                    {{$post->description}}
                                </p>
                                <div class="card-img" style="text-align: center">
                                    <a href="{{$post->photo}}" data-fancybox="gallery{{$post->id}}">
                                        <img src="{{$post->photo}}" alt="{{$post->title}}">
                                    </a>
                                </div>

                                <p>
                                    Автор:
                                    @if($post->user)
                                        <a href="{{ route('profile.show', ['profile' => $post->user->nickname]) }}">{{$post->user->name}}</a>
                                    @else
                                        <span>Deleted</span>
                                    @endif
                                </p>

                                <p>
                                    @if($post->category_id)
                                        Категория: <a href="{{route('posts-category', ['id' => $post->category->id])}}">{{$post->category->name}}</a>
                                    @endif
                                </p>

                                <form @auth class="like" @endauth action="{{ route('like') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$post->id}}" name="id">

                                    @php
                                        $like = false
                                    @endphp

                                    @auth
                                        @if($post->users && count($post->users) > 0)
                                            @foreach($post->users as $user)
                                                @if($user->id === auth()->user()->id)
                                                    @php
                                                        $like = true
                                                    @endphp
                                                    @break;
                                                @endif
                                            @endforeach
                                        @endif
                                    @endauth

                                    <button
                                        class="btn @php echo $like === false ? 'btn-success' : 'btn-danger' @endphp">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                    <span>{{$post->likes}}</span>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $posts->links() }}

        @else
            <p>
                Постов еще нет
            </p>

            @if(Route::currentRouteName() === 'posts-category')
                <p>
                    <a href="{{route('index')}}">Вернуться на главную</a>
                </p>
            @endif
        @endif
    </div>

@endsection

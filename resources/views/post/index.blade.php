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
            <h4 style="margin-bottom: 15px">Посты категории "{{$posts[0]->category->name}}"</h4>
            <p style="margin-bottom: 15px">
                <a href="{{route('posts')}}" class="btn btn-secondary">Ко всем постам</a>
            </p>
        @endif

        @if(Route::currentRouteName() === 'posts-user')
            <h4 style="margin-bottom: 20px">{{$posts[0]->user->name}}. Все посты участника</h4>
        @endif

        @if(Route::currentRouteName() === 'posts-group' && count($posts) > 0)
            <h4 style="margin-bottom: 20px">Все посты клана «{{$posts[0]->user->usermeta->getGroup->name}}»</h4>
        @endif


        @if($posts && count($posts) > 0)
            <div class="row align-items-center">

                @foreach($posts as $post)
                    <?php
                    $hasGroup = $post->user ? $post->user->usermeta->getGroup : false;
                    $color = $hasGroup ? $post->user->usermeta->getGroup->theme : '';
                    $groupName = $hasGroup ? $post->user->usermeta->getGroup->name : '';
                    $groupSlug = $hasGroup ? $post->user->usermeta->getGroup->slug : '';
                    ?>
                    <div class="col-lg-6">
                        <div class="card post-card">
                            <h5 class="card-header post-card__header">
                                <a class="<?=$color?>" href="{{route('posts-show', ['id' => $post->id])}}">{{$post->title}}</a>
                                @auth
                                    @php
                                        $isAuthorOrAdmin = false;
                                        if ($post->user) {
                                            $isAuthorOrAdmin = $post->user->id === auth()->user()->id || auth()->user()->isAdmin();
                                        } else {
                                            $isAuthorOrAdmin = auth()->user()->isAdmin();
                                        }
                                    @endphp
                                    @if($isAuthorOrAdmin)
                                        <a class="{{$color}}" href="{{route('posts.edit', ['post' => $post->id])}}"><i
                                                class="fa fa-edit"></i></a>
                                    @endif
                                @endauth
                            </h5>

                            <div class="card-body">
                                <p>
                                    {{$post->description}}
                                </p>
                                <div class="card-img" style="text-align: center">
                                    @if (count($post->images) > 1)
                                        <div class="post-images__slider owl-carousel">
                                            @foreach($post->images as $image)
                                                <a href="{{url('storage' . $image->src)}}"
                                                   data-fancybox="gallery{{$post->id}}">
                                                    <img src="{{url('storage' . $image->src)}}" alt="{{$post->title}}">
                                                </a>
                                            @endforeach
                                        </div>
                                    @elseif (count($post->images) == 1)
                                        <a href="{{url('storage' . $post->images[0]->src)}}"
                                           data-fancybox="gallery{{$post->id}}">
                                            <img src="{{url('storage' . $post->images[0]->src)}}"
                                                 alt="{{$post->title}}">
                                        </a>
                                    @else
                                        <img src="{{asset('img/default-post.png')}}" alt="default">
                                    @endif
                                </div>

                                <p>
                                    Автор:
                                    @if($post->user)
                                        <a class="{{$color}}"
                                           href="{{ route('profile.show', ['profile' => $post->user->nickname]) }}">{{$post->user->name}}</a>
                                        <i>
                                            @if($hasGroup)
                                                <small>
                                                    (клан <a class="{{$color}}"
                                                             href="{{route('group', ['slug' => $groupSlug])}}">
                                                        {{$groupName}}
                                                    </a>)
                                                </small>
                                            @endif
                                        </i>
                                    @else
                                        <span>Deleted</span>
                                    @endif
                                </p>

                                <p>
                                    @if($post->category_id)
                                        Категория: <a class="post-cat"
                                                      href="{{route('posts-category', ['id' => $post->category->id])}}">{{$post->category->name}}</a>
                                    @endif
                                </p>

                                <p>
                                    <small>Создан {{$post->created_at->diffForHumans() ?? ''}}</small>
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

            @if(in_array(Route::currentRouteName(), ['posts-category', 'posts-group']))
                <hr>
                <p>
                    <a href="{{route('posts')}}" class="btn btn-success">Перейти на главную</a>
                </p>
            @endif
        @endif
    </div>

@endsection

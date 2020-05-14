<?php
/**
 * @var $user App\Models\User;
 * @var $post App\Models\Post;
 */
$rate = count($user[0]->posts) + count($user[0]->userPosts) * 10;
?>

@extends('layouts.main')
@section('title', $user[0]->name)

<style>
    @keyframes rate {
        from {
            width: 0
        }
        to {
            width: {{$rate/10}}%;
        }
    }

    .rate {
        animation: rate ease-in 1s .5s 1 forwards;
    }
</style>

@auth
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.body.classList.add('<?=$user[0]->usermeta->getGroup->theme?>-bg');

            function animateValue(id, start, end, duration) {
                let range = end - start;
                let current = start;
                let increment = end > start ? 1 : -1;
                let stepTime = Math.abs(Math.floor(duration / range));
                let obj = document.getElementById(id);
                let timer = setInterval(function () {
                    current += increment;
                    obj.innerHTML = current;
                    if (current == end) {
                        clearInterval(timer);
                    }
                }, stepTime);
            }

            @if($rate > 0)
            animateValue("rate", 0, {{$rate}}, 1000);
            @endif()
        });
    </script>
@endauth

@section('content')
    <div class="container pb-5 profile-container">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="profile-img"
                     style="background-image:
                     @if($user[0]->usermeta->image)
                         url({{ url('storage' . $user[0]->usermeta->image)}})
                     @else
                         url({{asset('img/default-avatar.png')}})"
                @endif">
            </div>

            @if($user[0]->id == auth()->user()->id)
                <form class="profile-img__upload" action="/profile/uploadAvatar" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $user[0]->id }}" name="user_id">
                    <div class="form-group">
                        <input type="file" name="image" id="file" class="profile-img__input">
                        <label for="file" class="btn btn-tertiary js-labelFile">
                            <i class="icon fa fa-check"></i>
                            <span class="js-fileName">Загрузить фото</span>
                        </label>
                    </div>

                    @error('image')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </form>
            @endif
        </div>
        <div class="col-md-7 offset-md-1">

            <div class="profile-group">
                @if(!in_array($user[0]->usermeta->group, ['', null]))
                    <h6>
                        Участник клана
                        <a href="{{route('league', ['group' => $user[0]->usermeta->getGroup->name])}}"><i>«{{$user[0]->usermeta->getGroup->name}}
                                »</i></a>
                    </h6>
                @endif
                <h6 class="profile-rate">
                    <span>Рейтинг: <span id="rate">0</span></span>
                    <div class="rate"></div>
                </h6>
            </div>

            <form class="profile-info" method="post">
                @method('PUT')
                @csrf
                <h4 class="profile-name profile-block">
                    <input type="text" name="name" value="{{ $user[0]->name ?? old('name') }}" disabled
                           class="{{ $user[0]->usermeta->getGroup->theme }}">
                    <span class="error error-name"></span>
                </h4>
                <hr>

                <div class="profile-info__meta">
                    <div class="profile-age profile-block">Возраст:
                        <input name="age" type="text" disabled
                               value="@if(!in_array($user[0]->usermeta->age, [null, ''])){{$user[0]->usermeta->age}}@endif"
                               placeholder="Не указан">
                        <span class="error error-age"></span>
                    </div>
                    <div class="profile-phone profile-block">Телефон:
                        <input name="phone" type="text" disabled
                               value="@if(!in_array($user[0]->usermeta->phone, [null, ''])){{$user[0]->usermeta->phone}}@endif"
                               placeholder="Не указан">
                        <span class="error error-phone"></span>
                    </div>

                    <div class="profile-city profile-block">Город*:
                        <input name="city" type="text" disabled
                               value="@if(!in_array($user[0]->usermeta->city, [null, ''])){{$user[0]->usermeta->city}}@endif"
                               placeholder="Не указан">
                        <span class="error error-city"></span>
                    </div>

                    <div class="profile-vk profile-block profile-block__hideOnEdit">ВК:
                        @if(in_array($user[0]->usermeta->vk_link, [null, '']))
                            <span class="placeholder">Ссылка не указана</span>
                        @else
                            <a href="{{ $user[0]->usermeta->vk_link }}"
                               target="_blank">{{ $user[0]->usermeta->vk_link }}</a>
                        @endif
                    </div>
                    @if($user[0]->id == auth()->user()->id)
                        <div class="profile-vk profile-block profile-block__showOnEdit">ВК:
                            <input name="vk_link" type="text" value="{{ $user[0]->usermeta->vk_link }}"
                                   placeholder="Ссылка не указана">
                            <span class="error error-vk_link"></span>
                        </div>
                    @endif

                    <div class="profile-instagram profile-block profile-block__hideOnEdit">Инстаграм:
                        @if(in_array($user[0]->usermeta->instagram_link, [null, '']))
                            <a disabled="" class="placeholder">Ссылка не указана</a>
                        @else
                            <a href="{{ $user[0]->usermeta->instagram_link }}"
                               target="_blank">{{ $user[0]->usermeta->instagram_link }}</a>
                        @endif
                    </div>
                    @if($user[0]->id == auth()->user()->id)
                        <div class="profile-instagram profile-block profile-block__showOnEdit">Инстаграм:
                            <input name="instagram_link" type="text"
                                   value="{{ $user[0]->usermeta->instagram_link }}"
                                   placeholder="Ссылка не указана">
                            <span class="error error-instagram_link"></span>
                        </div>
                    @endif

                    <div class="profile-about profile-block profile-block__hideOnEdit">
                        <p>О себе: @if(!in_array($user[0]->usermeta->about, [null, '']))
                                <span>{{$user[0]->usermeta->about}}</span>
                            @else<span class="placeholder">{{'Нет информации'}}</span>@endif</p>
                    </div>
                    <div class="profile-about profile-block profile-block__showOnEdit">
                        О себе:
                        <textarea name="about"
                                  placeholder="Нет информации"
                                  disabled>{{ trim($user[0]->usermeta->about) ?? 'Нет информации' }}</textarea>
                        <span class="error error-about"></span>
                    </div>

                    @if($user[0]->id == auth()->user()->id)
                        <div class="profile-settings">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
                        <button class="btn btn-success profile-block__showOnEdit">Сохранить</button>
                    @endif
                </div>


            </form>
        </div>
    </div>
    </div>

    <hr>

    <div class="container pt-5">
        <div class="row">
            <div class="col-12">
                <div class="post-blocks__title-wrapper">
                    <h3 class="post-blocks__title">Посты</h3>
                    @if($user[0]->id == auth()->user()->id)
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">Добавить пост</a>
                    @endif
                </div>
                <hr>
                <div class="post-blocks @if(count($user[0]->userPosts)>1){{'post-blocks__slider owl-carousel'}}@endif">
                    @forelse($user[0]->userPosts as $post)
                        <div class="post-block">
                            <div class="post-block__title">
                                <h5>{{ $post->title }}</h5></div>
                            <div class="post-block__descr">
                                <p>{{ $post->description }}</p>
                            </div>
                            <small style="display: block; margin-bottom: 20px; font-style: italic">Кликните на
                                изображение, чтобы открыть просмотр фотографий</small>

                            @if (count($post->images) > 1)
                                <div class="post-block__img owl-carousel">
                                    @foreach($post->images as $image)
                                        <a href="{{url('storage' . $image->src)}}" data-fancybox="gallery{{$post->id}}">
                                            <img src="{{url('storage' . $image->src)}}" alt="{{$post->title}}">
                                        </a>
                                    @endforeach
                                </div>
                            @elseif (count($post->images) == 1)
                                <a href="{{url('storage' . $post->images[0]->src)}}"
                                   data-fancybox="gallery{{$post->id}}">
                                    <img src="{{url('storage' . $post->images[0]->src)}}" alt="{{$post->title}}">
                                </a>
                            @else
                                <a href="{{asset('img/default-post.png')}}"
                                   data-fancybox="gallery{{$post->id}}">
                                    <img src="{{asset('img/default-post.png')}}" alt="default">
                                </a>
                            @endif

                        </div>
                    @empty
                        <p>Постов нет</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection



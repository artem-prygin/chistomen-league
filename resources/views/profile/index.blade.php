<?php
/**
 * @var $user App\Models\User;
 * @var $post App\Models\Post;
 */
$rate = count($user->posts) + $user->user_posts_count * 10;
$hasGroup = $user->usermeta->getGroup;
$color = $user->usermeta->getGroup ? $user->usermeta->getGroup->theme : '';
$ifUserOrAdmin = auth()->user()->isAdmin() || $user->id == auth()->user()->id;
?>

@extends('layouts.main')
@section('title', $user->name)

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
        window.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('<?=$user->usermeta->getGroup? $user->usermeta->getGroup->theme : ''?>-bg');

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
                     @if($user->usermeta->image)
                         url({{ url('storage' . $user->usermeta->image)}})
                     @else
                         url({{asset('img/default-avatar.png')}})"
                @endif">
            </div>

            @if($ifUserOrAdmin)
                <form class="profile-img__upload" action="/profile/uploadAvatar" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" name="user_id">
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
                @if($hasGroup)
                    <h6>
                        Участник клана
                        <a href="{{route('group', ['slug' => $user->usermeta->getGroup->slug])}}"><i>«{{$user->usermeta->getGroup->name}}
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
                    <input type="text" name="name" value="{{ $user->name ?? old('name') }}" disabled
                           class="{{ $user->usermeta->getGroup->theme ?? '' }}">
                    <span class="error error-name"></span>
                </h4>
                <hr>

                <div class="profile-info__meta">
                    <div class="profile-age profile-block">Возраст:
                        <input name="age" type="text" disabled
                               value="@if(!in_array($user->usermeta->age, [null, ''])){{$user->usermeta->age}}@endif"
                               placeholder="Не указан">
                        <span class="error error-age"></span>
                    </div>
                    <div class="profile-phone profile-block">Телефон:
                        <input name="phone" type="text" disabled
                               value="@if(!in_array($user->usermeta->phone, [null, ''])){{$user->usermeta->phone}}@endif"
                               placeholder="Не указан">
                        <span class="error error-phone"></span>
                    </div>

                    <div class="profile-city profile-block">Город*:
                        <input name="city" type="text" disabled
                               value="@if(!in_array($user->usermeta->city, [null, ''])){{$user->usermeta->city}}@endif"
                               placeholder="Не указан">
                        <span class="error error-city"></span>
                    </div>

                    <div class="profile-vk profile-block profile-block__hideOnEdit">ВК:
                        @if(in_array($user->usermeta->vk_link, [null, '']))
                            <span class="placeholder">Ссылка не указана</span>
                        @else
                            <a href="{{ $user->usermeta->vk_link }}"
                               target="_blank">{{ $user->usermeta->vk_link }}</a>
                        @endif
                    </div>
                    @if($ifUserOrAdmin)
                        <div class="profile-vk profile-block profile-block__showOnEdit">ВК:
                            <input name="vk_link" type="text" value="{{ $user->usermeta->vk_link }}"
                                   placeholder="Ссылка не указана">
                            <span class="error error-vk_link"></span>
                        </div>
                    @endif

                    <div class="profile-instagram profile-block profile-block__hideOnEdit">Инстаграм:
                        @if(in_array($user->usermeta->instagram_link, [null, '']))
                            <a disabled="" class="placeholder">Ссылка не указана</a>
                        @else
                            <a href="{{ $user->usermeta->instagram_link }}"
                               target="_blank">{{ $user->usermeta->instagram_link }}</a>
                        @endif
                    </div>
                    @if($ifUserOrAdmin)
                        <div class="profile-instagram profile-block profile-block__showOnEdit">Инстаграм:
                            <input name="instagram_link" type="text"
                                   value="{{ $user->usermeta->instagram_link }}"
                                   placeholder="Ссылка не указана">
                            <span class="error error-instagram_link"></span>
                        </div>
                    @endif

                    <div class="profile-about profile-block profile-block__hideOnEdit">
                        <p>О себе: @if(!in_array($user->usermeta->about, [null, '']))
                                <span>{{$user->usermeta->about}}</span>
                            @else<span class="placeholder">{{'Нет информации'}}</span>@endif</p>
                    </div>
                    <div class="profile-about profile-block profile-block__showOnEdit">
                        О себе:
                        <textarea name="about"
                                  placeholder="Нет информации"
                                  disabled>{{ trim($user->usermeta->about) ?? 'Нет информации' }}</textarea>
                        <span class="error error-about"></span>
                    </div>

                    @if($ifUserOrAdmin)
                        <div class="profile-settings">
                            <i class="fa fa-cogs"></i>
                        </div>

                        <input type="hidden" value="{{ $user->id }}" name="user_id">
                        <button class="btn btn-success profile-block__showOnEdit">Сохранить</button>
                    @endif
                </div>


            </form>
        </div>
    </div>
    </div>

    <hr>

    {{--Last posts--}}

    <div class="container pt-5">
        <div class="row">
            <div class="col-12">
                <div class="post-blocks__title-wrapper">
                    <h3 class="post-blocks__title">Последние посты</h3>
                    @if($user->user_posts_count > 2)
                        <a href="{{ route('posts-user', ['nickname' => $user->nickname]) }}" class="btn btn-primary">Все
                            посты</a>
                    @endif
                    @if($user->id == auth()->user()->id)
                        <a href="{{ route('posts.create') }}" class="btn btn-success">Добавить пост</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($user->userPosts as $post)
                <div class="col-lg-6">
                    <div class="card post-card">
                        <h5 class="card-header post-card__header {{$color}}">
                            <span>{{$post->title}}</span>
                            @if($post->user->id === auth()->user()->id || auth()->user()->isAdmin())
                                <a class="{{$color}}" href="{{route('posts.edit', ['post' => $post->id])}}"><i class="fa fa-edit"></i></a>
                            @endif
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
                                @if($post->category_id)
                                    Категория: <a
                                        href="{{route('posts-category', ['id' => $post->category->id])}}">{{$post->category->name}}</a>
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
            @empty
                <div class="col-12">
                    <p>Нет постов</p>
                </div>
            @endforelse
        </div>
    </div>
    </div>
    </div>
@endsection



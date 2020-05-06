<?php
/**
 * @var $user App\Models\User;
 * @var $post App\Models\Post;
 */
?>

@extends('layouts.main')
@section('title', $user[0]->name)

@section('content')
    <div class="container pb-5 profile-container">
        <div class="row align-items-center">
            <div class="col-4">
                <div class="profile-img" style="background-image: url({{ $user[0]->usermeta->image ?? asset('img/default-avatar.png') }})"></div>

                <form class="profile-img__upload" action="/profile/uploadAvatar" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $user[0]->id }}" name="user_id">
                    <div class="form-group">
                        <input type="file" name="image" id="file" class="profile-img__input">
                        <label for="file" class="btn btn-tertiary js-labelFile">
                            <i class="icon fa fa-check"></i>
                            <span class="js-fileName">Загрузить файл</span>
                        </label>
                    </div>

                    @error('image')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </form>
            </div>
            <div class="col-7 offset-1">
                <form class="profile-info" method="post">
                    @method('PUT')
                    @csrf
                    <h4 class="profile-name profile-block">
                        <input type="text" name="name" value="{{ $user[0]->name ?? old('name') }}" disabled>
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
                                <a href="{{ $user[0]->usermeta->vk_link }}">{{ $user[0]->usermeta->vk_link }}</a>
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
                                <a href="{{ $user[0]->usermeta->instagram_link }}">{{ $user[0]->usermeta->instagram_link }}</a>
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
                <h3 class="post-blocks__title">Посты</h3>
                <div class="post-blocks @if(count($posts)>1){{'post-blocks__slider owl-carousel'}}@endif">
                    @foreach($posts as $post)
                        <div class="post-block">
                            <div class="post-block__title">
                                <h5>{{ $post->title }}</h5></div>
                            <div class="post-block__descr">
                                <p>{{ $post->description }}</p>
                            </div>
                            <div class="post-block__img">
                                <img src="{{$post->photo}}" alt="{{ $post->title }}">
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

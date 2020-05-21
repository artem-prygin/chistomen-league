<?php
/**
 * @var $categories \App\Models\Category
 * @var $post \App\Models\Post
 */
?>

@extends('layouts.main')
@section('title', 'Редактировать пост')

@section('content')
    <div class="container">
        <form method="post" action="/posts/{{$post->id}}" enctype="multipart/form-data" class="post-create post-edit__form">
            @method('PUT')
            @csrf
            <input type="hidden" name="author" value="{{ auth()->user()->id }}">
            <div class="form-group">
                <label for="post_title">Заголовок*</label>
                <input type="text" name="title" class="form-control" id="post_title" required
                       placeholder="Уборка на Финском заливе" value="{{old('title') ?? $post->title ?? ''}}">
                <small>не более 200 символов</small>
                @error('title')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="post_description">Описание*</label>
                <textarea class="form-control" name="description" id="post_description" rows="3" required
                          placeholder="Собрали 100500 мешков биомусора">{{old('description') ?? $post->description ?? ''}}</textarea>
                <small>не более 1000 символов</small>
                @error('description')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post_category">Выберите категорию из списка...</label>
                <select name="category_id" id="post_category" class="post-category form-control"
                        style="width: 100%" multiple>
                    <option value=""></option>
                    @foreach($categories as $cat)
                        <option
                            value="{{$cat->id}}"
                        @if((old('category_id') && old('category_id') == $cat->id) ||
                            (!old('name') && !(old('category_id')) && $post->category->id == $cat->id))
                            {{__('selected')}}
                            @endif
                        >{{$cat->name}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">...или добавьте новую</label>
                <input class="form-control post-category__new" type="text" name="name" id="name"
                       value="{{old('name') ?? ''}}">
                <small>не более 20 символов</small>
                @error('category_id')
                <span class="error">{{$message}}</span>
                @enderror
                @error('name')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="post-images">
                @foreach($post->images as $image)
                    <div class="post-image" data-image="{{$image->id}}">
                        <span data-image="{{$image->id}}" data-extension="{{explode('.', $image->src)[1]}}"
                              class="post-image__close"><i class="fa fa-close"></i></span>
                        <img src="{{url('storage' . $image->src)}}" alt="{{$post->title}}">
                    </div>
                @endforeach
                <input type="hidden" name="deletedImages" value="" id="deleted-images">
            </div>

            <div class="form-group">
                <label for="post_photo">Добавить фото</label>
                <input type="file" multiple name="photo[]" id="post_photo" style="display: block"
                       required>
                <small>еще не более <span class="post-images__left">{{5 - count($post->images)}}</span> фото в формате png/jpg и не более 4Мб каждая</small>
                <input type="hidden" name="images-left" value="{{5 - count($post->images)}}">
                @error('photo')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
        </form>

        <hr>

        <div class="form-group">
            <div class="post-buttons">
                <button class="btn btn-primary" id="post-edit">Редактировать пост</button>
                <button class="btn btn-danger" id="post-delete">Удалить пост</button>

                <form action="{{route('posts.destroy', ['post' => $post->id])}}" id="post-delete__form" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="author" value="{{$post->author}}">
                </form>
            </div>
        </div>
    </div>
@endsection

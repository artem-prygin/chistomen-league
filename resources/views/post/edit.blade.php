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
        <form method="post" action="/posts/{{$post->id}}" enctype="multipart/form-data" class="post-create">
            @method('PUT')
            @csrf
            <input type="hidden" name="author" value="{{ auth()->user()->id }}">
            <div class="form-group">
                <label for="post_title">Заголовок*</label>
                <input type="text" name="title" class="form-control" id="post_title" required
                       placeholder="Уборка на Финском заливе" value="{{old('title') ?? $post->title ?? ''}}">
                <small>не более 40 символов</small>
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

            <hr>

            <div class="form-group">
                <button class="btn btn-primary">Редактировать пост</button>
            </div>
        </form>
    </div>
@endsection

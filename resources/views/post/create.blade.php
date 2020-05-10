<?php
/**
 * @var $categories \App\Models\Category
 */
?>

@extends('layouts.main')
@section('title', 'Добавить пост')

@section('content')
    <div class="container">
        <form method="post" action="/posts" enctype="multipart/form-data" class="post-create">
            @csrf
            <input type="hidden" name="author" value="{{ auth()->user()->id }}">
            <div class="form-group">
                <label for="post_title">Заголовок*</label>
                <input type="text" name="title" class="form-control" id="post_title" required
                       placeholder="Уборка на Финском заливе" value="{{old('title') ?? ''}}">
                <small>не более 40 символов</small>
                @error('title')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="post_description">Описание*</label>
                <textarea class="form-control" name="description" id="post_description" rows="3" required
                          placeholder="Собрали 100500 мешков биомусора">{{old('description') ?? ''}}</textarea>
                <small>не более 500 символов</small>
                @error('description')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            @if($categories)
                <div class="form-group">
                    <label for="post_category">Выберите категорию из списка...</label>
                    <select name="category_id" id="post_category" class="post-category form-control"
                            style="width: 100%" multiple>
                        <option value=""></option>
                        @foreach($categories as $cat)
                            <option
                                value="{{$cat->id}}" {{old('category_id') == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">...или добавьте новую</label>
                    <input class="form-control post-category__new" type="text" name="name" id="name" value="{{old('name') ?? ''}}">
                    <small>не более 20 символов</small>
                    @error('category_id')
                    <span class="error">{{$message}}</span>
                    @enderror
                </div>
            @else
                <div class="form-group">
                    <label for="name">Категория*</label>
                    <input class="form-control" type="text" name="name" id="name" required value="{{old('name') ?? ''}}">
                    <small>не более 20 символов</small>
                    @error('name')
                    <span class="error">{{$message}}</span>
                    @enderror
                </div>
            @endif

            <div class="form-group">
                <label for="post_photo">Фото*</label>
                <input type="file" multiple name="photo[]" id="post_photo" style="display: block" value="{{old('photo') ?? ''}}"
                       required>
                <small>не более 5 фото в формате png/jpg и не более 2Мб каждая</small>
                @error('photo')
                <span class="error">{{$message}}</span>
                @enderror
            </div>

            <hr>

            <div class="form-group">
                <button class="btn btn-primary">Добавить пост</button>
            </div>
        </form>
    </div>
@endsection

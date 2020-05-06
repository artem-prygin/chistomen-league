@extends('layouts.main')
@section('title', 'Добавить пост')

@section('content')
    <div class="container">
        <form method="post" action="/posts" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="author" value="{{ auth()->user()->id }}">
            <div class="form-group">
                <label for="post_title">Заголовок*</label>
                <input type="text" name="title" class="form-control" id="post_title"
                       placeholder="Уборка на Финском заливе" value="{{old('title') ?? ''}}">
                @error('title')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="post_description">Описание*</label>
                <textarea class="form-control" name="description" id="post_description" rows="3"
                          placeholder="Собрали 100500 мешков биомусора">{{old('description') ?? ''}}</textarea>
                @error('description')
                <span class="error">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="post_photo">Фото*</label>
                <input type="file" name="photo" id="post_photo" placeholder="Lets fake the link" style="display: block">
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

@extends('layouts.main')
@section('title', 'Редактирование клана')

@section('content')
    <div class="container">
        <form action="{{route('manager-groups-store')}}" method="post" id="group-edit">
            @csrf
            <div class="form-group">
                <label for="name">Название</label>
                <input class="form-control" id="name" name="name" type="text" value="{{old('name') ?? ''}}">
                @error('name')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="theme">Тема</label>
                <br>
                <small>Задайте фоновый цвет клана (на английском языке). Нельзя использовать следующие цвета:
                    @foreach($themes as $theme)
                        <span class="{{$theme->theme}}">{{$theme->theme}}</span>
                    @endforeach
                </small>
                <input class="form-control" id="theme" name="theme" type="text" value="{{old('theme') ?? ''}}">
                @error('theme')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">Слаг</label>
                <input class="form-control" id="slug" name="slug" type="text" value="{{old('slug') ?? ''}}">
                @error('slug')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control" name="description" id="description" rows="5">{{old('description') ?? ''}}</textarea>
                @error('description')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <button class="btn btn-primary">Создать клан</button>
        </form>
    </div>
@endsection

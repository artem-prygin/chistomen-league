<?php

/**
 * @var $group \App\Models\Group
 */

?>

@extends('layouts.main')
@section('title', 'Редактирование клана')

@section('content')
    <div class="container">
        <form action="{{route('manager-groups-update', ['group' => $group->id])}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Название</label>
                <input class="form-control" id="name" name="name" type="text" value="{{old('name') ?? $group->name}}">
                @error('name')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="theme">Тема</label>
                <input class="form-control" id="theme" name="theme" type="text" value="{{old('theme') ?? $group->theme}}">
                @error('theme')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">Слаг</label>
                <input class="form-control" id="slug" name="slug" type="text" value="{{old('slug') ?? $group->slug}}">
                @error('slug')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control" name="description" id="description" rows="5">{{old('description') ?? $group->description}}</textarea>
                @error('description')
                    <span class="error">{{$message}}</span>
                @enderror
            </div>

            <button class="btn btn-primary">Редактировать</button>
        </form>
    </div>
@endsection

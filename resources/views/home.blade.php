<?php
/**
 * @var $groups \App\Models\Group
 */
?>

@extends('layouts.main')
@section('title', 'Главная')

@section('content')
    <div class="container">
        <h1>Добро пожаловать в ЭкоЛигу!</h1>
        <hr>
        <h3>
            Список кланов:
        </h3>
        <div class="row">
            @foreach($groups as $group)
                <div class="col-12 mb-2">
                    <div class="card">
                        <div class="card-body {{$group->theme}}-bg">
                            <h4>
                                <a class="{{$group->theme}}"
                                   href="{{route('group', ['slug' => $group->slug])}}">{{$group->name}}</a>
                            </h4>
                            <p>{{mb_substr($group->description, 0, 50)}}<a class="{{$group->theme}}"
                                                                           href="{{route('group', ['slug' => $group->slug])}}">...
                                    читать дальше</a>
                            </p>

                            <a href="{{route('group', ['slug' => $group->slug])}}" class="btn btn-secondary mb-1">Подробнее</a>
                            @guest
                                <a href="{{route('register', ['group' => $group->name])}}" class="btn btn-primary mb-1">Присоединиться</a>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

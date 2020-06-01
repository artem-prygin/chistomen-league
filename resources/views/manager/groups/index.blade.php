<?php

/**
 * @var $group \App\Models\Group
 */

?>

@extends('layouts.main')
@section('title', 'Список кланов')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show profile-alert" role="alert">
                <span>{{session('success')}}</span>
                <button class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

            <a class="btn btn-success" href="{{route('manager-groups-create')}}">Создать клан</a>
            <hr>

        @foreach($groups as $group)
            <div class="manager-group">
                <h2>
                    <a href="{{route('manager-groups-edit', ['group' => $group->id ])}}">
                        {{$group->name}}
                    </a>
                </h2>
                <div>Тема: <span>{{$group->theme}}</span></div>
                <div>Слаг: <span>{{$group->slug}}</span></div>
                <hr>
            </div>
        @endforeach
    </div>
@endsection

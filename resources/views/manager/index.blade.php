@extends('layouts.main')
@section('title', 'Страница менеджера')

@section('content')
    <div class="container">

        <div class="manager-buttons">
            <a href="{{route('manager-groups')}}" class="btn btn-primary">Группы</a>
            <a href="{{route('league')}}" class="btn btn-success">Участники</a>
        </div>

    </div>
@endsection

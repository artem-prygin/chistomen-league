<?php

use App\Models\User;

/**
 * @var $users User
 */
?>

@extends('layouts.main')
@section('title', 'Посты')

@section('content')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя / Псевдоним</th>
                <th scope="col">Город</th>
                <th scope="col">Ссылка на профиль</th>
            </tr>
            </thead>
            <tbody>
            <form action="{{ route('league') }}" class="league-filter" method="get">
                <tr>
                    <th scope="row"></th>
                    <td>
                        <input type="text" class="league-input" name="name" value="{{request('name') ?? ''}}">
                    </td>
                    <td>
                        <input type="text" class="league-input" name="city" value="{{request('city') ?? ''}}">
                    </td>
                    <td></td>
                </tr>
            </form>
            @php $i=1 @endphp
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$i++}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->usermeta->city}}</td>
                <td><a href="{{route('profile.show', ['profile' => $user->nickname])}}">
                        <i class="fa fa-home"></i>
                    </a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

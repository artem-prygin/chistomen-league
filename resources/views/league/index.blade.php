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
        <div class="table-wrapper">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя / Псевдоним</th>
                    <th scope="col">Город</th>
                    <th scope="col">Клан</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <form action="{{ route('league') }}" class="league-filter" method="get">
                    <tr>
                        <td colspan="2">
                            <input type="text" class="league-input" name="name" value="{{request('name') ?? ''}}" placeholder="Введите имя">
                        </td>
                        <td>
                            <input type="text" class="league-input" name="city" value="{{request('city') ?? ''}}" placeholder="Введите город">
                        </td>
                        <td>
                            <input type="text" class="league-input" name="group" value="{{request('group') ?? ''}}" placeholder="Название клана">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary">Применить фильтр</button>
                        </td>
                    </tr>
                </form>
                @php $i=1 @endphp
                @forelse($users as $user)
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>
                            <a href="{{route('profile.show', ['profile' => $user->nickname])}}">{{$user->name}}</a>
                        </td>
                        <td>{{$user->usermeta->city}}</td>
                        <td>{{$user->usermeta->getGroup->name ?? '-'}}</td>
                        <td></td>
                    </tr>
                @empty
                    <tr >
                        <td colspan="4">Никого и ничего не найдено :(</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

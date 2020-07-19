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
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя / Псевдоним</th>
                    <th scope="col">Город</th>
                    <th scope="col">Клан</th>
                    <th scope="col"></th>
                    @if(auth()->user()->isAdmin())
                        <th scope="col"></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                <form action="{{ route('league') }}" class="league-filter" method="get">
                    <tr>
                        <td colspan="2">
                            <input type="text" class="league-input" name="name" value="{{request('name') ?? ''}}"
                                   placeholder="Введите имя">
                        </td>
                        <td>
                            <input type="text" class="league-input" name="city" value="{{request('city') ?? ''}}"
                                   placeholder="Введите город">
                        </td>
                        <td>
                            <input type="text" class="league-input" name="group" value="{{request('group') ?? ''}}"
                                   placeholder="Название клана">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary">Применить фильтр</button>
                        </td>
                        @if(auth()->user()->isAdmin())
                            <td></td>
                        @endif
                    </tr>
                </form>
                @php $i = request('page') ? request('page') * 10 - 9 @endphp
                @forelse($users as $user)
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>
                            <a href="{{route('profile.show', ['profile' => $user->nickname])}}">{{$user->name}}</a>
                        </td>
                        <td>{{$user->usermeta->city}}</td>
                        <td>
                            @if($user->usermeta->getGroup)
                                <a href="{{route('group', ['slug' => $user->usermeta->getGroup->slug])}}">{{$user->usermeta->getGroup->name ?? '-'}}</a>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td></td>
                        @if(auth()->user()->isAdmin() && $user->id != auth()->user()->id)
                            <td style="color: red;">
                                <i class="fa fa-trash" style="cursor: pointer"
                                onclick="if(confirm('Точно удалить участника? Его нельзя будет восстановить'))
                                {document.getElementById('user{{$user->id}}').submit()}"></i>
                                <form action="{{route('profile.destroy', ['profile' => $user->id])}}"
                                      method="post" style="display: none" id="user{{$user->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Никого и ничего не найдено :(</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection

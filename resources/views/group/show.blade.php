<?php
/**
 * @var $group \App\Models\Group
 */
?>

@section('title', $group[0]->name)

@extends('layouts.main')

@auth
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            document.body.classList.add('<?=$group[0]->theme?>-bg');

            function animateValue(id, start, end, duration) {
                let range = end - start;
                let current = start;
                let increment = end > start ? 1 : -1;
                let stepTime = Math.abs(Math.floor(duration / range));
                let obj = document.getElementById(id);
                let timer = setInterval(function () {
                    current += increment;
                    obj.innerHTML = current;
                    if (current == end) {
                        clearInterval(timer);
                    }
                }, stepTime);
            }
        });
    </script>
@endauth


@section('content')
<div class="container">
    <h2 class="{{$group[0]->theme}}">{{$group[0]->name}}</h2>
    <p>
        {{$group[0]->description}}
    </p>

    <hr>
    <h4>Участники клана: </h4>
    <ul>
        @forelse($group[0]->users as $user)
            <li><a href="{{route('profile.show', ['profile' => $user->user->nickname])}}">{{$user->user->name}}</a></li>
        @empty
            <li>В клане пока нет ни одного участника</li>
        @endforelse
    </ul>

    <hr>
    <a href="{{route('posts-group', ['slug' => $group[0]->slug])}}" class="btn btn-primary">Посты участников клана</a>
</div>
@endsection


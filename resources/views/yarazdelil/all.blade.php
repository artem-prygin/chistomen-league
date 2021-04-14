<?php
/**
 * @var $post \App\Models\Yarazdelil
 */
?>

@extends('layouts.main')
@section('title', '#яРазделил, #яСортирую - Все розыгрыши')


@section('content')
    <div class="container">
        <a href="{{route('yarazdelil')}}" class="btn btn-secondary">К текущему розыгрышу</a>
        <hr>
        <h3 class="text-center">Все прошедшие розыгрыши #яРазделил</h3>
        <hr>
        <div class="row">
            @forelse($weeks as $week)
                <div class="col-6 offset-3">
                    <a href="{{route('yarazdelil.show', ['week' => $week->week_id])}}"
                       class="btn {{$week->week_id%2 === 0? 'btn-success' : 'btn-primary'}} d-block text-center mb-1">Розыгрыш
                        №{{$week->week_id}}

                        от {{$week->updated_at->format('d-m-Y')}}
                    </a>
                </div>
            @empty
                <div class="col-6">
                    <p>Пока не было розыгрышей</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection

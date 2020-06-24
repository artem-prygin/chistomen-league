<?php
/**
 * @var $post \App\Models\Yaubral
 */
?>

@extends('layouts.main')
@section('title', '#яУбрал - Все розыгрыши')


@section('content')
    <div class="container">
        <a href="{{route('yaubral')}}" class="btn btn-secondary">К текущему розыгрышу</a>
        <hr>
        <h3 class="text-center">Все прошедшие розыгрыши #яУбрал</h3>
        <hr>
        <div class="row">
            @forelse($weeks as $week)
                <div class="col-6 offset-3">
                    <a href="{{route('yaubral.show', ['week' => $week->week_id])}}"
                       class="btn {{$week->week_id%2 === 0? 'btn-success' : 'btn-primary'}} d-block text-center mb-1">Розыгрыш
                        №{{$week->week_id}} от {{$week->updated_at->format('d-m-Y')}}</a>
                </div>
            @empty
                <p>Пока не было розыгрышей</p>
            @endforelse
        </div>
    </div>

@endsection

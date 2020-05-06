<?php

use App\Models\Post;

/**
 * @var $posts Post
 * @var $post Post
 */
?>

@extends('layouts.main')
@section('title', 'Карта')

<script src="https://api-maps.yandex.ru/2.1/?apikey=ed9252f1-9884-4559-80f3-4d9ba84c1222&lang=ru_RU" type="text/javascript"></script>

@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div id="map" style="width: 100%; height: 80vh"></div>
        </div>
    </div>

    <script type="text/javascript">
        ymaps.ready(init);
        var mainCoordinates = [];
        $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode=Москва&results=1', function (data) {
            mainCoordinates = data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');
        });

        window.events = [[], [], []];
        @foreach($users as $user)
        $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode={{$user->usermeta->city}}&results=1', function (data) {
            window.events[0].push(data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' '));
            window.events[1].push('{{$user->name}}');
            window.events[2].push('/profile/{{$user->nickname}}');
        });
        @endforeach

        function init() {
            var myMap = new ymaps.Map("map", {
                    center: [mainCoordinates[1], mainCoordinates[0]],
                    zoom: 4
                }, {
                    searchControlProvider: 'yandex#search'
                }),

                collection = new ymaps.GeoObjectCollection(null, {
                    preset: 'islands#blackStretchyIcon',
                    iconColor: 'green'
                }),
                coords = [];

            for (let i = 0; i < window.events[0].length; i++) {
                coords.push([window.events[0][i][1], window.events[0][i][0]]);
            }

            for (let i = 0; i < coords.length; i++) {
                collection.add(new ymaps.Placemark(coords[i],
                    {
                        iconContent: window.events[1][i],
                        url: window.events[2][i],
                    }));
            }
            myMap.geoObjects.add(collection)
            myMap.behaviors.disable('scrollZoom')

            myMap.geoObjects.events.add('click', function (e) {
                window.open(e.get('target').properties.get('url'));
            });
            // Через коллекции можно подписываться на события дочерних элементов.
            //collection.events.add('click', function () { alert('Кликнули по желтой метке') });

            // Через коллекции можно задавать опции дочерним элементам.
            //blueCollection.options.set('preset', 'islands#blueDotIcon');
        }

    </script>

@endsection

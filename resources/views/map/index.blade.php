<?php

use App\Models\Post;

/**
 * @var $posts Post
 * @var $post Post
 */
?>

@extends('layouts.main')
@section('title', 'Карта')

<script src="https://api-maps.yandex.ru/2.1/?apikey=ed9252f1-9884-4559-80f3-4d9ba84c1222&lang=ru_RU"
        type="text/javascript"></script>
<style>
    main {
        padding: 0 !important;
    }

    .loader,
    .loader:before,
    .loader:after {
        background: green;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 4em;
    }

    .loader {
        color: green;
        text-indent: -9999em;
        margin: 88px auto;
        position: relative;
        font-size: 11px;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
    }

    .loader:before,
    .loader:after {
        position: absolute;
        top: 0;
        content: '';
    }

    .loader:before {
        left: -1.5em;
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
    }

    .loader:after {
        left: 1.5em;
    }

    @-webkit-keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
    }

    @keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
    }

</style>

@section('content')
    <div id="map" style="width: 100%; height: 85vh"></div>

    <script>
        async function map() {
            let points = [];
            let spinner = document.createElement('div');
            let map = document.getElementById('map');
            spinner.classList.add('loader');
            map.appendChild(spinner);
            window.events = [[], [], [], [], []]
            @foreach($users as $user)
                await $.getJSON('https://geocode-maps.yandex.ru/1.x/?apikey=ab380256-636c-4346-8de3-8177483ab96f&format=json&geocode={{$user->usermeta->city}}&results=1', function (data) {
                if (undefined !== data.response.GeoObjectCollection.featureMember[0]) {
                    window.events[0].push(data.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' '));
                    window.events[1].push('{{$user->name}}');
                    window.events[2].push('/profile/{{$user->nickname}}');
                    window.events[3].push('{{$user->usermeta->city}}');
                    window.events[4].push('{{$user->usermeta->image ?? 'img/default-avatar.png'}}');
                }
            });
            @endforeach

            map.removeChild(spinner);

            ymaps.ready(init);

            function init() {
                var myMap = new ymaps.Map('map', {
                        center: ["55.753215", "37.622504"],
                        zoom: 9,
                        preset: 'islands#blackStretchyIcon'
                    }, {
                        searchControlProvider: 'yandex#search'
                    }),
                    clusterer = new ymaps.Clusterer({
                        // Зададим массив, описывающий иконки кластеров разного размера.
                        clusterIcons: [
                            {
                                href: 'img/logo.jpg',
                                size: [60, 60],
                                offset: [-30, -30]
                            }],
                        groupByCoordinates: false,
                        clusterDisableClickZoom: false,
                        clusterHideIconOnBalloonOpen: false,
                        geoObjectHideIconOnBalloonOpen: false,
                        clusterIconContentLayout: null,
                        clusterBalloonContentLayoutWidth: 260,
                    }),
                    coords = [];
                for (let i = 0; i < window.events[0].length; i++) {
                    coords.push([window.events[0][i][1], window.events[0][i][0]]);
                }
                getPointData = function (index) {
                    return {
                        balloonContentHeader: `<strong>${window.events[1][index]}</strong>
                                                <br><small>город: ${window.events[3][index]}</small>`,
                        balloonContentBody: `<a style="width: 120px; text-align: center; display: block" href="${window.events[2][index]}">
                                                <div style="margin: 5px auto; background: url(${window.events[4][index]}) center no-repeat;
                                                background-size: cover; border-radius: 50%; width: 100px; height: 100px"></div>
                                                   <span>Перейти в профиль</span>
                                               </a>`,
                        clusterCaption: `<strong>${window.events[1][index]}</strong>
                                            <br><small>город: ${window.events[3][index]}</small>`
                    };
                };
                getPointOptions = function () {
                    return {
                        iconLayout: 'default#image',
                        iconImageHref: 'img/logo.jpg',
                        iconImageSize: [40, 40],
                        iconImageOffset: [-10, -5]
                    };
                };
                points = coords;
                let geoObjects = [];

                for (var i = 0, len = points.length; i < len; i++) {
                    geoObjects[i] = new ymaps.Placemark(points[i], getPointData(i), getPointOptions());
                }

                clusterer.options.set({
                    gridSize: 80,
                    clusterDisableClickZoom: true
                });

                clusterer.add(geoObjects);
                myMap.geoObjects.add(clusterer);
                // myMap.behaviors.disable('scrollZoom');

                myMap.setBounds(clusterer.getBounds(), {
                    checkZoomRange: true
                });
            }
        }

        map();
    </script>

@endsection

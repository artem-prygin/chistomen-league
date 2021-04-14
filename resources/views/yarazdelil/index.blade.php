<?php
/**
 * @var $post \App\Models\Yarazdelil
 */
?>

@extends('layouts.main')
@section('title', '#яРазделил, #яСортирую')
@section('styles')
    <style>
        main {
            padding-top: 0;
        }
    </style>
    <script>
        function popupWindow(url, title, win, w, h) {
            const y = win.top.outerHeight / 2 + win.top.screenY - (h / 2);
            const x = win.top.outerWidth / 2 + win.top.screenX - (w / 2);
            return win.open(url, title, `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=${w}, height=${h}, top=${y}, left=${x}`);
        }
    </script>
@endsection

@section('content')
    @if(\Request::route()->getName() === 'yarazdelil')
        <div class="yarazdelil">
            <div class="yarazdelil-vk">
                <a href="https://vk.com/yaubral" target="_blank">
                    <i class="fa fa-vk"></i>
                </a>
            </div>
{{--            <div class="yarazdelil-play">--}}
{{--                <img src="{{asset('img/play.png')}}" alt="play">--}}
{{--            </div>--}}
{{--            <div class="yarazdelil-play__overlay"></div>--}}
{{--            <div class="yarazdelil-play__popup">--}}
{{--                <iframe src="https://www.youtube.com/embed/3D0NNu7f7pU" frameborder="0"--}}
{{--                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"--}}
{{--                        allowfullscreen></iframe>--}}
{{--            </div>--}}
            <div class="yarazdelil-overlay"></div>
            <div class="yarazdelil-text">
                <div class="container">
                    <div class="yarazdelil-text__wrapper">
                        <h1>
                            <a href="https://vk.com/yaubral" target="_blank">#яРазделил, #яСортирую</a>
                        </h1>
                        <h2>1000 рублей каждую неделю</h2>
                        <hr>
                        <p>
                            <span>Примите участие в еженедельном розыгрыше приза за раздельный сбор отходов (РСО)!</span>
                            <span>Выложите в любой социальной сети фотографию, как Вы сортируете отходы с хэштегом
                    #яРазделил или #яСортирую, отправьте ссылку на пост в форму ниже и участвуйте в розыгрыше.</span>
                        </p>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show profile-alert" role="alert">
                                <span>{{session('success')}}</span>
                                <button class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show profile-alert" role="alert">
                                <span>{{session('error')}}</span>
                                <button class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <form action="{{route('yarazdelil.store')}}" class="yarazdelil-form" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="text" placeholder="Имя" name="author" class="form-control"
                                                   required value="{{old('author') ?? ''}}">
                                            @error('author')
                                            <span class="error yarazdelil-error">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input type="url" placeholder="Ссылка на пост (https://...)" name="link"
                                                   class="form-control"
                                                   required value="{{old('link') ?? ''}}">
                                            @error('link')
                                            <span class="error yarazdelil-error">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button class="btn btn-warning d-block m-auto yarazdelil-btn">Участвовать</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @auth
            <div class="container">
                <form action="" method="post" style="display: none" class="getWinner">
                    @csrf
                </form>
                <button class="yarazdelil-getWinner btn btn-success ml-auto mr-auto mt-5
            @if(auth()->user()->isYaubral() && count($confirmed) > 0)
                    d-block
            @endif
                    ">Выбрать победителя
                    недели
                </button>
            </div>
        @endauth

        <div class="container">
            <div class="yarazdelil-winner">
                <div class="yarazdelil-loading">
                    <img src="{{asset('img/yaubral-loading.gif')}}" alt="loading">
                </div>
                <div class="yarazdelil-winner"></div>
            </div>
        </div>
    @endif

    @if(\Request::route()->getName() === 'yarazdelil.show')
        <div class="container mt-5">
            <a href="{{route('yarazdelil.showAll')}}" class="btn btn-secondary">К списку розыгрышей</a>
            <hr>
        </div>


        @if(session('video-success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show profile-alert" role="alert">
                    <span>{{session('video-success')}}</span>
                    <button class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show profile-alert" role="alert">
                    <span>{{session('error')}}</span>
                    <button class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="yarazdelil-winner">
                <h3>Победитель розыгрыша №{{$week}}: {{$winner->author}}</h3>
                <p>
                        <span>
                        Посмотреть пост:
                        </span>
                    <a href="{{$winner->link}}" target="_blank"
                       onclick="popupWindow(this.href, this.target, window, 1500, 800)">
                        {{$winner->link}}
                    </a>
                </p>

                @auth
                    @if(auth()->user()->isYaubral())
                        <a class="btn btn-danger reGet-winner"
                           href="{{route('yarazdelil.changeWinner', ['week' => $winner->week_id])}}">Переиграть
                            розыгрыш</a>

                        <a class="btn btn-success add-winner"
                           href="{{route('yarazdelil.addWinner', ['week' => $winner->week_id])}}">Добавить победителя</a>
                    @endif
                @endauth
            </div>

            @foreach($addWinners as $addWinner)
                <div class="yarazdelil-addWinners">
                    <h4>Дополнительный победитель: {{$addWinner->author}}</h4>
                    <p>
                            <span>
                            Посмотреть пост:
                            </span>
                        <a href="{{$addWinner->link}}" target="_blank"
                           onclick="popupWindow(this.href, this.target, window, 1500, 800)">
                            {{$addWinner->link}}
                        </a>
                    </p>
                </div>
                <hr>
            @endforeach
        </div>
    @endif

    <div class="yarazdelil-posts">
        <div class="container">
            <h3>Участники розыгрыша #{{$week}}</h3>
            <div class="yarazdelil-posts__table">
                <table class="table table-striped">
                    <thead>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Ссылка</th>
                    <th>Дата добавления поста</th>
                    <th>Модерация</th>
                    @auth
                        @if(auth()->user()->isYaubral() && \Request::route()->getName() === 'yarazdelil')
                            <th></th>
                            <th></th>
                        @endif
                    @endauth
                    </thead>
                    <tbody>
                    @php $i = 1 @endphp
                    @foreach($posts as $post)
                        <tr data-id="{{$post->id}}" @if($post->win === 1) class="lightgreen"
                            @elseif($post->add_winner === 1) class="bg-orange" @endif>
                            <td>{{$i++}}</td>
                            <td>{{$post->author}}</td>
                            <td class="yarazdelil-link">
                                <a href="{{$post->link}}"
                                   onclick="popupWindow(this.href, this.target, window, 1500, 800)">
                                    {{$post->link}}
                                </a>
                            </td>
                            <td>{{$post->created_at}}</td>
                            <td data-id="{{$post->id}}">
                                @if($post->checked === 0)
                                    <span class="orange">На модерации</span>
                                @elseif($post->checked === 1)
                                    <span class="green">Принято</span>
                                @else
                                    <span class="red">Отклонено</span>
                                @endif
                            </td>
                            @auth
                                @if(auth()->user()->isYaubral() && \Request::route()->getName() === 'yarazdelil')
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$post->id}}" name="id">
                                            <i class="fa fa-check yarazdelil-moderation yarazdelil-moderation__ok"
                                               data-id="{{$post->id}}"></i>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            @csrf
                                            <input type="hidden" value="{{$post->id}}" name="id">
                                            <i class="fa fa-close yarazdelil-moderation yarazdelil-moderation__delete"
                                               data-id="{{$post->id}}"></i>
                                        </form>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


            @if(\Request::route()->getName() === 'yarazdelil')
                <a href="{{route('yarazdelil.showAll')}}" class="btn btn-secondary mt-4">Прошедшие розыгрыши</a>
            @endif

            @if(\Request::route()->getName() === 'yarazdelil.show' && !is_null($winner->video))
                <hr>
                <h3>Видео розыгрыша</h3>
                <a href="{{$winner->video}}" target="_blank"
                   class="yarazdelil-videoLin mb-3 d-block">{{$winner->video}}</a>
                @auth
                    @if(auth()->user()->isYaubral())
                        <form action="{{route('yarazdelil.addVideo', ['week' => $week])}}" method="post"
                              class="yarazdelil-change__videoLink">
                            @csrf
                            <div class="form-group">
                                <input type="url" name="video" placeholder="Ссылка" class="form-control" required>
                            </div>
                            @if(session('video'))
                                <div class="alert alert-danger alert-dismissible fade show profile-alert" role="alert">
                                    <span>{{session('video')}}</span>
                                    <button class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="form-group">
                                <button class="btn btn-primary">Добавить/изменить</button>
                            </div>
                        </form>

                    @endif
                @endauth
            @endif

            @auth
                @if(\Request::route()->getName() === 'yarazdelil.show' && is_null($winner->video) && auth()->user()->isYaubral())
                    <hr>
                    <h5>Добавить ссылку на видео розыгрыша: </h5>
                    <form action="{{route('yarazdelil.addVideo', ['week' => $week])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="url" name="video" placeholder="Ссылка" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                @endif
            @endauth

        </div>
    </div>




@endsection

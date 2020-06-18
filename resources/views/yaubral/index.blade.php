<?php
/**
 * @var $post \App\Models\Yaubral
 */
?>

@extends('layouts.main')
@section('title', '#яУбрал')
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
    <div class="yaubral">
        <div class="yaubral-overlay"></div>
        <div class="yaubral-text">
            <div class="container">
                <div class="yaubral-text__wrapper">
                    <h1>
                        <a href="https://vk.com/yaubral" target="_blank">#яУбрал</a>
                    </h1>
                    <h2>1000 рублей каждую неделю</h2>
                    <hr>
                    <p>
                        <span>Примите участие в еженедельном розыгрыше приза за уборку мусора!</span>
                        <span>Выложите в любой социальной сети фотографию ДО|ПОСЛЕ как Вы убрали мусор в любимом городе с хэштегом
                    #яубрал, отправьте ссылку на пост в форму ниже и участвуйте в розыгрыше.</span>
                        <span style="font-style: italic">!!! Посты ЭкоЛиги в категории "Уборка" участвуют в конкурсе автоматически !!!</span>
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
                            <form action="{{route('yaubral.store')}}" class="yaubral-form" method="post">
                                @csrf
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="text" placeholder="Имя" name="author" class="form-control"
                                               required value="{{old('author') ?? ''}}">
                                        @error('author')
                                        <span class="error yaubral-error">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="text" placeholder="Ссылка на пост" name="link" class="form-control"
                                               required value="{{old('link') ?? ''}}">
                                        @error('link')
                                        <span class="error yaubral-error">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary d-block m-auto yaubral-btn">Участвовать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        @if(auth()->user()->isYaubral())
            <div class="container pt-5">
                <form action="" method="post" style="display: none" class="getWinner">
                    @csrf
                </form>
                <button class="yaubral-getWinner btn btn-success ml-auto mr-auto d-block mb-2">Выбрать победителя
                    недели
                </button>
            </div>
        @endif
    @endauth
    <div class="container">
        <div class="yaubral-winner">
            <div class="yaubral-loading">
                <img src="{{asset('img/yaubral-loading.gif')}}" alt="loading">
            </div>
            <div class="yaubral-winner"></div>
        </div>
    </div>


    <div class="yaubral-posts">
        <div class="container">
            <h3>Участники розыгрыша #{{$week}}</h3>
            <table class="table table-striped">
                <thead>
                <th>#</th>
                <th>Имя</th>
                <th>Ссылка</th>
                <th>Дата добавления поста</th>
                <th>Модерация</th>
                @auth
                    @if(auth()->user()->isYaubral())
                        <th></th>
                        <th></th>
                    @endif
                @endauth
                </thead>
                <tbody>
                @php $i=1 @endphp
                @foreach($posts as $post)
                    <tr data-id="{{$post->id}}">
                        <td>{{$i++}}</td>
                        <td>{{$post->author}}</td>
                        <td class="yaubral-link">
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
                            @if(auth()->user()->isYaubral())
                                <td>
                                    <form action="" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$post->id}}" name="id">
                                        <i class="fa fa-check yaubral-moderation yaubral-moderation__ok"
                                           data-id="{{$post->id}}"></i>
                                    </form>
                                </td>
                                <td>
                                    <form action="" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$post->id}}" name="id">
                                        <i class="fa fa-close yaubral-moderation yaubral-moderation__delete"
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
    </div>




@endsection

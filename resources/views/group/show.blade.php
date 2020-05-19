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
        @if(count($group[0]->users) > 0)
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
                    @php $i=1 @endphp
                    @forelse($group[0]->users as $user)
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td>
                                <a href="{{route('profile.show', ['profile' => $user->user->nickname])}}">{{$user->user->name}}</a>
                            </td>
                            <td>{{$user->city}}</td>
                            <td>{{$group[0]->name ?? '-'}}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Никого и ничего не найдено :(</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <p>В клане пока нет ни одного участника</p>
        @endif

        <hr>

        <h4 style="margin-bottom: 20px">Все посты клана «{{$group[0]->name}}»</h4>
        @if($posts && count($posts) > 0)
            <div class="row align-items-center">

                @foreach($posts as $post)
                    <?php
                    $color = $post->user->usermeta->getGroup->theme;
                    $groupName = $post->user->usermeta->getGroup->name;
                    $groupSlug = $post->user->usermeta->getGroup->slug;
                    ?>
                    <div class="col-lg-6">
                        <div class="card post-card">
                            <h5 class="card-header post-card__header <?=$color?>">
                                <span>{{$post->title}}</span>
                                @auth
                                    @if($post->user->id === auth()->user()->id)
                                        <a class="{{$color}}" href="{{route('posts.edit', ['post' => $post->id])}}"><i
                                                class="fa fa-edit"></i></a>
                                    @endif
                                @endauth
                            </h5>
                            <div class="card-body">
                                <p>
                                    {{$post->description}}
                                </p>
                                <div class="card-img" style="text-align: center">
                                    @if (count($post->images) > 1)
                                        <div class="post-images__slider owl-carousel">
                                            @foreach($post->images as $image)
                                                <a href="{{url('storage' . $image->src)}}"
                                                   data-fancybox="gallery{{$post->id}}">
                                                    <img src="{{url('storage' . $image->src)}}" alt="{{$post->title}}">
                                                </a>
                                            @endforeach
                                        </div>
                                    @elseif (count($post->images) == 1)
                                        <a href="{{url('storage' . $post->images[0]->src)}}"
                                           data-fancybox="gallery{{$post->id}}">
                                            <img src="{{url('storage' . $post->images[0]->src)}}"
                                                 alt="{{$post->title}}">
                                        </a>
                                    @else
                                        <img src="{{asset('img/default-post.png')}}" alt="default">
                                    @endif
                                </div>

                                <p>
                                    Автор:
                                    @if($post->user)
                                        <a class="{{$color}}"
                                           href="{{ route('profile.show', ['profile' => $post->user->nickname]) }}">{{$post->user->name}}</a>
                                        <i>
                                            <small>
                                                (клан <a class="{{$color}}"
                                                         href="{{route('group', ['slug' => $groupSlug])}}">
                                                    {{$groupName}}
                                                </a>)
                                            </small>
                                        </i>
                                    @else
                                        <span>Deleted</span>
                                    @endif
                                </p>

                                <p>
                                    @if($post->category_id)
                                        Категория: <a class="post-cat"
                                                      href="{{route('posts-category', ['id' => $post->category->id])}}">{{$post->category->name}}</a>
                                    @endif
                                </p>

                                <form @auth class="like" @endauth action="{{ route('like') }}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$post->id}}" name="id">

                                    @php
                                        $like = false
                                    @endphp

                                    @auth
                                        @if($post->users && count($post->users) > 0)
                                            @foreach($post->users as $user)
                                                @if($user->id === auth()->user()->id)
                                                    @php
                                                        $like = true
                                                    @endphp
                                                    @break;
                                                @endif
                                            @endforeach
                                        @endif
                                    @endauth

                                    <button
                                        class="btn @php echo $like === false ? 'btn-success' : 'btn-danger' @endphp">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                    <span>{{$post->likes}}</span>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $posts->links() }}

        @else
            <p>
                Постов еще нет
            </p>
        @endif
    </div>
@endsection


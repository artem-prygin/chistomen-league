@extends('layouts.main')
@section('title', 'Подтвердите email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтвердите адрес своей электронной почты') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Мы снова отправили вам письмо, так уж и быть...') }}
                        </div>
                    @endif

                    {{ __('Проверьте свою почту, там нужно будет на кнопочку в письме кликнуть') }}.
                        <br>
                    {{ __('А если письма нет (кстати, в спаме смотрели?), то') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('давайте попробуем еще раз') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

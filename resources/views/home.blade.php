@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Здесь нет ничего интересного</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <a href="{{route('')}}" class="btn btn-primary">Досвидос</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title')
    {{ $user->getNameOrUsername() }}
@endsection

@section('content')

<div class="container">
    <div class="row">
    <div class="wrapper">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $user->getNameOrUsername() }}
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <img src="{{ $user->getAvatarUrl(80) }}" alt="" style="border-radius: 100%; width: 80px; display: block; margin-left: 50px;">
                        
                            <div class="home-menu">
                                <ul class="list-group">
                                    <a href="{{ route('user.items', $user->id) }}">
                                        <li class="list-group-item">Добавленные вещи <span class="badge">{{ $user->items->count() }}</span></li>
                                    </a>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- wrapper --}}
    </div>
    {{-- wrapper --}}
    </div>
</div>

@endsection
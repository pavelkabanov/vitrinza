@extends('layouts.app')

@section('title')
    {{ $item->name }}
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="item-left col-md-6 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            <div style="display: inline-block;">    
                                <h1>{{ $item->name }}</h1>

                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}">

                                @if ($item->link)
                                    <p>
                                    @if ($item->partner())
                                        <a href="{{ $item->partner() }}">Ссылка на эту вещь в интернет-магазине</a>
                                    @else
                                        <a href="{{ $item->getHost() }}">Ссылка на эту вещь в интернет-магазине</a>
                                    @endif
                                    </p>
                                @endif
                                

                                <div style="margin-top: 30px;">
                                @if (Auth::check())

                                    <favorite
                                        item-slug="{{ $item->slug }}"
                                        favorited="{{ $item->favoritedBy(Auth::user()) ? true : false }}"
                                        fav-count="{{ $item->favorites->count() }}"
                                    ></favorite>

                                    <item-likes
                                        item-slug="{{ $item->slug }}"
                                        liked="{{ $item->likedBy(Auth::user()) ? true : false }}"
                                        like-count="{{ $item->likes->count() }}"
                                    ></item-likes>
                                
                                @else
                                    <div class="favs-bar">
                                        <span>{{ $item->favorites->count() }}</span>
                                        <a href="#" onclick="event.preventDefault()" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="<a href={{ url('/login') }}>Войдите</a> на сайт, чтобы добавить в избранное">
                                            <i class="glyphicon glyphicon-star" data-toggle="tooltip" data-placement="bottom" title="Добавить в избранное"></i>
                                        </a>
                                    </div>
                                    <div class="likes-bar">
                                        <span>{{ $item->likes->count() }}</span>
                                        <a href="#" onclick="event.preventDefault()" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="<a href={{ url('/login') }}>Войдите</a> на сайт, чтобы поставить лайк">
                                            <i class="glyphicon glyphicon-heart" data-toggle="tooltip" data-placement="bottom" title="Нравится"></i>
                                        </a>
                                    </div>

                                @endif
                            </div>

                            </div>
                        </div>
                        <div class="item-right col-md-4 col-md-offset-1 col-xs-10 col-xs-offset-1">
                            @if ($item->description)
                                <article>{!! nl2br(e($item->description)) !!}</article>
                            @endif
                            <div style="margin-top: 30px;">
                                <p>Добавил:</p>
                                <img src="{{ $item->user->getAvatarUrl(40) }}" style="max-width: 50px; border-radius: 100%;">
                                <a href="{{ route('user.show', ['user' => $item->user->id]) }}">{{ explode(' ', $item->user->getNameOrUserName())[0] }}</a>
                            </div>
                            <div style="margin-top: 30px;">
                                {{ $item->created_at->diffForHumans() }}
                            </div>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="panel">
                            <div class="panel-body">
                                <item-comments item-slug="{{ $item->slug }}"></item-comments>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/tooltips.js') }}"></script>
@endsection
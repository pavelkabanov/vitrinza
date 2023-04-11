@extends('layouts.app')

@section('title')
    {{ $user->getNameOrUsername() }} - добавленные вещи
@endsection

@section('content')

    <div class="wrapper">
        <div class="cont">
            <div class="grid">
                @foreach ($items as $item)
                    <div class="item-show" id="item-{{ $item->id }}">
                        <div class="img-wrap">
                            @if (Auth::user() == $user)
                                <item-delete item-slug="{{ $item->slug }}">
                                </item-delete>
                            @endif
                            <a href="{{ route('item.show', ['slug' => $item->slug]) }}">
                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}">
                            </a>

                            <div class="titl">
                                <h3><a href="{{ route('item.show', ['slug' => $item->slug]) }}">{{ $item->name }}</a></h3>
                            </div>

                            <div class="user">
                                <a href="{{ route('user.show', ['user' => $item->user->id]) }}">
                                <img src="{{ $item->user->getAvatarUrl(80) }}" data-toggle="tooltip" data-placement="bottom" title="{{ explode(' ', $item->user->getNameOrUserName())[0] }}">
                                </a>
                                {{-- <a href="{{ route('user.show', ['user' => $item->user->id]) }}">{{ explode(' ', $item->user->getNameOrUserName())[0] }}</a> --}}

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
                        <div id="cover-{{ $item->slug }}" style="display: none;position: absolute; top: -3px; left: -3px; bottom: -5px; right: -5px; background: #f5f8fa; opacity: 0.8; z-index: 2;">
                        </div>
                        {{-- <a href="#" id="restore-1" style="display: block; position: absolute; top: 45%; z-index: 3; padding: 5px; background: #f0f0f0;">Восстановить</a> --}}
                        @if (Auth::user() == $user)
                            <item-restore item-slug="{{ $item->slug }}">
                            </item-restore>
                        @endif
                    </div>
                @endforeach
            </div>

            <div style="text-align: center;">
                {{ $items->links() }}
            </div>
        </div>
    </div>


@endsection


@section('js-scripts')
    <script type="text/javascript" src="{{ URL::asset('js/masonry.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/imagesloaded.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/masonry-grid.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/tooltips.js') }}"></script>
@endsection
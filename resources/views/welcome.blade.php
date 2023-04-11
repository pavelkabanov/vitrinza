@extends('layouts.app')

@section('title')
    Главная
@endsection

@section('content')

    <div class="wrapper">
        <div class="cont">
            <div class="grid">
                @foreach ($items as $item)
                    <div class="item-show">
                        <div class="img-wrap">
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
                                    <div class="favs-bar">
                                            <span>
                                            @if($item->favorites->count() > 0)
                                                {{ $item->favorites->count() }}
                                            @endif
                                            </span>
                                            @if ($item->favoritedBy(Auth::user()))
                                                <a href="#" data-slug="{{ $item->slug }}" data-action="unfavorite" onclick="event.preventDefault()">
                                                    <i class="glyphicon glyphicon-star" data-toggle="tooltip" data-placement="bottom" title="Убрать из избранного"></i>
                                                </a>
                                            @else
                                                <a href="#" data-slug="{{ $item->slug }}" data-action="favorite" onclick="event.preventDefault()">
                                                    <i class="glyphicon glyphicon-star-empty" data-toggle="tooltip" data-placement="bottom" title="Добавить в избранное"></i>
                                                </a>
                                            @endif
                                    </div>

                                    <div class="likes-bar">
                                            <span>
                                            @if ($item->likes->count() > 0)
                                                {{ $item->likes->count() }}
                                            @endif
                                            </span>
                                            @if ($item->likedBy(Auth::user()))
                                                <a href="#" data-slug="{{ $item->slug }}" data-action="unlike" onclick="event.preventDefault()">
                                                    <i class="glyphicon glyphicon-heart" data-toggle="tooltip" data-placement="bottom" title="Отменить лайк"></i>
                                                </a>
                                            @else
                                                <a href="#" data-slug="{{ $item->slug }}" data-action="like" onclick="event.preventDefault()">
                                                    <i class="glyphicon glyphicon-heart-empty" data-toggle="tooltip" data-placement="bottom" title="Нравится"></i>
                                                </a>
                                            @endif
                                    </div>
                                @else

                                    <div class="favs-bar">
                                        <span>
                                        @if($item->favorites->count() > 0)
                                            {{ $item->favorites->count() }}
                                        @endif
                                        </span>
                                        <a href="#" onclick="event.preventDefault()" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="<a href={{ url('/login') }}>Войдите</a> на сайт, чтобы добавить в избранное">
                                            <i class="glyphicon glyphicon-star" data-toggle="tooltip" data-placement="bottom" title="Добавить в избранное"></i>
                                        </a>
                                    </div>
                                    <div class="likes-bar">
                                        <span>
                                        @if ($item->likes->count() > 0)
                                            {{ $item->likes->count() }}
                                        @endif
                                        </span>
                                        <a href="#" onclick="event.preventDefault()" data-toggle="popover" data-placement="bottom" data-trigger="focus" data-content="<a href={{ url('/login') }}>Войдите</a> на сайт, чтобы поставить лайк">
                                            <i class="glyphicon glyphicon-heart" data-toggle="tooltip" data-placement="bottom" title="Нравится"></i>
                                        </a>
                                    </div>

                                @endif

                            </div>
                        </div>
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
    <script type="text/javascript" src="{{ URL::asset('js/infinite-scroll.min.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/masonry-grid.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/inf.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/tooltips.js') }}"></script>

    <script>
        $( document ).ready(function() {
            $(".likes-bar a").click(function (e) {
                e.preventDefault();
                //console.log($(this).data("slug"));
                
                if ($(this).attr('data-action') === "like") {
                    axios.post('/item/' + $(this).data("slug") + '/like')
                        .then((response) => {
                            var likesCount = parseInt($(this).parent().find("span").text());
                            if(!likesCount) likesCount = 0;
                            likesCount++;
                            $(this).parent().find("span").text(likesCount);
                            $(".tooltip").remove();
                            $(this).find(".glyphicon-heart-empty").replaceWith("<i class='glyphicon glyphicon-heart' data-toggle='tooltip' data-placement='bottom' title='Отменить лайк'></i>");
                            $('[data-toggle="tooltip"]').tooltip();

                            $(this).attr('data-action', 'unlike');

                        })
                        .catch(response => console.log(response.data));
                }

                if ($(this).attr('data-action') === "unlike") {
                    axios.post('/item/' + $(this).data("slug") + '/unlike')
                        .then((response) => {
                            var likesCount = parseInt($(this).parent().find("span").text());
                            likesCount--;
                            $(this).parent().find("span").text(likesCount);
                            if(likesCount < 1) $(this).parent().find("span").empty();
                            $(".tooltip").remove();
                            $(this).find(".glyphicon-heart").replaceWith("<i class='glyphicon glyphicon-heart-empty' data-toggle='tooltip' data-placement='bottom' title='Нравится'></i>");
                            $('[data-toggle="tooltip"]').tooltip();
                            $(this).attr('data-action', 'like');

                        })
                        .catch(response => console.log(response.data));
                }
            });


            $(".favs-bar a").click(function (e) {
                e.preventDefault();
                //console.log($(this).data("slug"));
                
                if ($(this).attr('data-action') === "favorite") {
                    axios.post('/item/' + $(this).data("slug") + '/favorite')
                        .then((response) => {
                            var favoritesCount = parseInt($(this).parent().find("span").text());
                            if(!favoritesCount) favoritesCount = 0;
                            favoritesCount++;
                            $(this).parent().find("span").text(favoritesCount);
                            $(".tooltip").remove();
                            $(this).find(".glyphicon-star-empty").replaceWith("<i class='glyphicon glyphicon-star' data-toggle='tooltip' data-placement='bottom' title='Убрать из избранного'></i>");
                            $('[data-toggle="tooltip"]').tooltip();
                            $(this).attr('data-action', 'unfavorite');

                        })
                        .catch(response => console.log(response.data));
                }

                if ($(this).attr('data-action') === "unfavorite") {
                    axios.post('/item/' + $(this).data("slug") + '/unfavorite')
                        .then((response) => {
                            var favoritesCount = parseInt($(this).parent().find("span").text());
                            favoritesCount--;
                            $(this).parent().find("span").text(favoritesCount);
                            if(favoritesCount < 1) $(this).parent().find("span").empty();
                            $(".tooltip").remove();
                            $(this).find(".glyphicon-star").replaceWith("<i class='glyphicon glyphicon-star-empty' data-toggle='tooltip' data-placement='bottom' title='Добавить в избранное'></i>");
                            $('[data-toggle="tooltip"]').tooltip();
                            $(this).attr('data-action', 'favorite');

                        })
                        .catch(response => console.log(response.data));
                }
            });

        });
    </script>
@endsection
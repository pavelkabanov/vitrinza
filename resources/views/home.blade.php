@extends('layouts.app')

@section('title')
    Профиль
@endsection

@section('content')

@if (Session::has('alert-success'))
    <div class="alert alert-info col-md-10 col-md-offset-1" role="alert">
        {{ Session::get('alert-success') }}
    </div>
@endif
<div class="wrapper">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ Auth::user()->getNameOrUsername() }}
                    
                    <div class="dropdown" style="padding-left: 130px; display: inline-block; float: right;">
                        <span class="glyphicon glyphicon-cog dropdown-toggle" style="cursor: pointer; opacity: .7;" data-toggle="dropdown"></span>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Выход</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            {{-- @if (count(Auth::user()->social)) --}}
                                <img src="{{ Auth::user()->getAvatarUrl(80) }}" alt="" style="border-radius: 100%; width: 80px; display: block; margin-left: 50px;">
                            {{-- @endif --}}
                        
                            <div class="home-menu">
                                <ul class="list-group">
                                    <a href="{{ route('user.items', Auth::id()) }}">
                                        <li class="list-group-item">Добавленные вещи <span class="badge">{{ Auth::user()->items->count() }}</span></li>
                                    </a>
                                    <a href="{{ url('/my-favorites') }}">
                                        <li class="list-group-item">
                                        Избранные вещи <span class="badge">{{ Auth::user()->favoriteItems->count() }}</span>
                                    </li>
                                    </a>
                                </ul>
                            </div>

                        </div>
                        <div class="col-md-7">
                            <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#create_item" style="float: right; outline: none;"><span class="glyphicon glyphicon-plus-sign" style="top: 4px; right: 3px;"></span> Добавить вещь</button>
                            
                            @include('item.post')
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
    @if (count($errors) > 0)
        @include('item.modal')
    @endif

    <script>

        function coverImage() {
            var d = document.getElementById("imageDiv");
            var a = document.getElementById("imageLink");
            if(a) {
                d.removeChild(a);
            }
            document.getElementById("uploadPreview").style.display = 'inline-block';

            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            }

            //document.getElementById("uploadImage").style.top = '-152px';
            d.style.background = '#ffffff';
            d.style.border = 'none';
        }

    </script>

    <script>
    $( document ).ready(function() {
        function getSubcategories (subcat = '') {
            $("#subcategory").parent().remove();
            if($("#category").val()) {
            axios.get('/subcategories/' + $("#category").val())
                    .then((response) => {
                        //console.log(response.data[0].id);
                        if(response.data) {
                            var newEl = "<div class='form-group'><label for='subcategory'>Подкатегория:</label><select class='form-control' id='subcategory' name='subcategory'><option></option>";
                            response.data.forEach(function(item, i, arr) {
                                if(subcat && subcat == item.id) {
                                    newEl += "<option value='" + item.id + "' selected>" + item.title + "</option>";
                                }
                                else {
                                    newEl += "<option value='" + item.id + "'>" + item.title + "</option>";
                                }
                            });
                            newEl += "</select></div>";
                            $("#category").parent().after(newEl);
                        }
                        else {
                            $("#subcategory").parent().remove();
                        }
                    })
                    .catch(response => console.log(response.data));
            }
            else $("#subcategory").parent().remove();
        }

        $("#category").change(function () {
            getSubcategories();
        });
        @if (old('category'))
            getSubcategories({{ old('subcategory') }});
        @endif
    });
    </script>
@endsection

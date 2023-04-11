@extends('layouts.app')

@section('title')
    Регистрация
@endsection

@section('content')
<div class="container login-container">
    <div class="row">
        <div class="col-md-12">
                        <h3>Войдите через социальные сети</h3>
                        <h5>(рекомендуется)</h5>
                        <a href="{{ url('/login/vkontakte') }}" class="social-btn btn-vk"><span>Войти через Вконтакте</span></a>
                        <div></div>
                        <a href="{{ url('/login/facebook') }}" class="social-btn btn-fb"><span>Войти через Facebook</span></a>

                        <h3>или зарегистрируйтесь</h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                                <div class="login-field">
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Никнейм" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div class="login-field">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <div class="login-field">
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Пароль" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="login-field">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Повторите пароль" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="login-field">
                                    <button type="submit" class="btn btn-primary">
                                        Зарегистрироваться
                                    </button>
                                </div>
                            </div>
                        </form>
        </div>
    </div>
</div>
@endsection

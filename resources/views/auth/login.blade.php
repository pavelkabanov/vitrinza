@extends('layouts.app')

@section('title')
    Вход
@endsection

@section('content')
<div class="container login-container">
    <div class="row">
        <div class="col-md-12">
                        <h3>Вход через социальные сети</h3>
                        <h5>(рекомендуется)</h5>
                        <a href="{{ url('/login/vkontakte') }}" class="social-btn btn-vk"><span>Войти через Вконтакте</span></a>
                        <div></div>
                        <a href="{{ url('/login/facebook') }}" class="social-btn btn-fb"><span>Войти через Facebook</span></a>

                        <h3>или Email</h3>
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <div class="login-field">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

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
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="login-field">
                                    <button type="submit" class="btn btn-primary">
                                        Войти
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Забыли пароль?
                                    </a>
                                </div>
                            </div>
                        </form>
        </div>
    </div>
</div>
@endsection

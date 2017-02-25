@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ Session::has('errors') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Identificacion</label>

                            <div class="col-md-6">
                                <input id="persona_identificacion" type="text" class="form-control" name="persona_identificacion" value="{{ old('persona_identificacion') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ Session::has('errors') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Codigo</label>

                            <div class="col-md-6">
                                <input id="persona_codigo_alterno" type="text" class="form-control" name="persona_codigo_alterno" value="{{ old('persona_codigo_alterno') }}" required autofocus>

                                @if (Session::has('errors'))
                                    <span class="help-block">
                                        @foreach ($errors->all() as $error)
                                            <strong>{{ $error }}</strong>
                                        @endforeach
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>--}}

                        {{-- <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                {{--<a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

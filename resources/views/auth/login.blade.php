@extends('layouts.app')
@section('css')
<style>

    .formulario-inicio{
    -webkit-box-shadow: 10px 10px 7px -8px rgba(0,0,0,0.75);
    -moz-box-shadow: 10px 10px 7px -8px rgba(0,0,0,0.75);
    box-shadow: 10px 10px 7px -8px rgba(0,0,0,0.75);
    }

    .form-control-feedback {
        position: absolute;
        padding: 10px;
        pointer-events: none;
        margin-top:2px;
        color:#0E486D;
    
    }

    .form-control {
        padding-left: 34px!important;
    } 

    input::-webkit-input-placeholder {
        color:   #0B4AA8;
        font-size:13px;
    }
    input::-moz-placeholder {
        color:   #0B4AA8;
        font-size:13px;
    }
   
   .button{background: #57948A;font-size: 14px;cursor: pointer;border:none;border-radius: 5px;}
    .button:hover {background: #3E946E !important;}
</style>


@section('content')

<div class="container mt-lg-4" style="background:url('{{asset("img/fondo-test.jpg")}}');background-size: cover">
    <div class="row justify-content-start">
        <div class="col-12  text-white p-1 text-center" style="background: #57948A;">
            <span style="letter-spacing: 0.25em;">Intranet {{ config('app.name') }}</span>
        </div>
        <div class="col-lg-4 mt-5 mb-5 ">
            <div class="card formulario-inicio">
                <div class="text-dark p-2" style="border-bottom: 1px solid #CECECE"><span class="ml-2"><i><strong><img src="{{asset('img/img_black.png')}}" height="20" width="20"><span class="ml-2">Inicia Sesión</span></strong></i></span></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" style="margin-bottom: -20px">
                        @csrf

                        <div class="form-group row">
                            

                            <div class="col-12">
                                
                                <i class="fa fa-envelope form-control-feedback" style="font-size: 14px"></i>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Ingrese su Cuenta de Correo">

                                @if ($errors->has('email'))
                                    

                                        @if( substr($errors->first('email'), 0, 10)=='Demasiados')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Demasiados intentos de acceso. comuniquese con el administrador</strong>



                                                @inject('bloqueo', 'App\User')
  
                                                <?php

                                                $email = old('email');

                                                $bloqueo->bloqueo_usuario_intentos_fallidos($email);
      
                                                

                                                ?>
                                            </span>
                                        @else
                                            
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>

                                        @endif
                                    
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-12">
                                <i class="fa fa-lock form-control-feedback" style="font-size: 18px"></i>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Ingrese su Contraseña">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                

                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" class="button col-12 text-white">
                                    {{ __('Aceptar') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" style="font-size: 14px" href="{{ route('password.request') }}">
                                        {{ __('Olvide mi contraseña') }}
                                    </a>
                                @endif
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

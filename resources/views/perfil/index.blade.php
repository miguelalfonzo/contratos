@extends('layout')
@section('css')


  
@endsection
@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><span class="badge badge-primary text-white"><i class="fa fa-user" style="margin-right:6px"></i>Mi Perfil</span> &nbsp<span class="badge badge-dark text-white">{{$usuario->nombres}} {{$usuario->apellido_paterno}} {{$usuario->apellido_materno}}</span></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form method="POST" class="form-horizontal form-label-left" action="{{url('/salvar_perfil')}}" enctype="multipart/form-data" novalidate>
                      @csrf
                      <div class="col-md-4 col-sm-12">
                        <div class="text-center">
                        <img id="preview" src="{{asset((Auth::user()->imagen!=null)?'profiles/'.Auth::user()->imagen:'img/noimage.png')}}"style="border-radius: 50%" height="150" width="150">
                        <input type="file" id="setImage" name="setImage" style="display: none">
                        </div>
                        <div class="text-center " style="margin-top: 20px">
                          <a href="javascript:changeProfile();" class="badge badge-primary">cambiar</a>
                          <a href="javascript:removeImage()" class="badge badge-danger">eliminar</a>
                          <input type="hidden" style="display: none" value="0" name="remove" id="remove"> 
                        </div>
                      </div>


                      <div class="col-md-8 col-sm-12">
                      <div class="item form-group">
                        <input type="hidden" name="user_id" id="user_id" value="{{$usuario->id}}">

                        <input type="hidden" name="email_contacto" id="email_contacto" value="{{$usuario->EmailContacto}}">

                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_nombre">Nombres <span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input id="user_nombre" name="user_nombre" class=" form-control resize-input resize-font" value="{{ old('user_nombre', $usuario->nombres) }}"required="required"  autocomplete="off" type="text" maxlength="100" >

                          @if ($errors->has('user_nombre'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('user_nombre')}}</strong></span>
                          @endif
                        </div>
                        
                      </div>

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ape_pat">Apellido Paterno <span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input class=" form-control resize-input resize-font" id="ape_pat" name="ape_pat" value="{{old('ape_pat',$usuario->apellido_paterno)}}"required="required" autocomplete="off" type="text" maxlength="100">

                          @if ($errors->has('ape_pat'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('ape_pat')}}</strong></span>
                          @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ape_mat">Apellido Materno <span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input class=" form-control resize-input resize-font" id="ape_mat" name="ape_mat"  value="{{old('ape_mat',$usuario->apellido_materno)}}" required="required" autocomplete="off" type="text" maxlength="100">
                          @if ($errors->has('ape_mat'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('ape_mat')}}</strong></span>
                          @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="celular">Celular 
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input class=" form-control resize-input resize-font" id="celular" name="celular" onkeypress="return validateNumber(event);" autocomplete="off" value="{{old('celular',$usuario->Celular)}}"  type="text" maxlength="11">
                          @if ($errors->has('celular'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('celular')}}</strong></span>
                          @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="fijo">Teléfono Fijo 
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input class=" form-control resize-input resize-font" id="fijo" name="fijo"  autocomplete="off" onkeypress="return validateNumber(event);" value="{{old('fijo',$usuario->Fijo)}}"  type="text" maxlength="11">
                          @if ($errors->has('fijo'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('fijo')}}</strong></span>
                          @endif
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_estado">Estado<span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <select id="user_estado" name="user_estado" class="chosen">
                            {{-- <option value="">seleccione estado</option> --}}

                            @if($usuario->flag_activo==1)
                              <option value="1" selected>activo</option>
                            @else
                                <option value="0" selected >inactivo</option>
                            @endif

                            
                           
                          </select>
                          @if ($errors->has('user_estado'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('user_estado')}}</strong></span>
                          @endif
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email <span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <input type="email" id="email" name="email"  required="required" class="form-control resize-input resize-font" value="{{old('email',$usuario->email)}}" autocomplete="off" maxlength="100">
                          @if ($errors->has('email'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('email')}}</strong></span>
                          @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="password" class="col-form-label col-md-3 label-align">Password <span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 input-group">
                          <input id="password" type="password" name="password"  class="form-control resize-input resize-font" autocomplete="off" required="required" value="{{old('password',$usuario->password)}}">
                          <span class="input-group-btn">
                                              <a href="#" data-toggle="tooltip" data-placement="right" data-original-title="la contraseña debe tener como minimo 8 dígitos . al menos un número , una minúscula y una mayúscula" class="btn btn-dark" style="padding: 0px 4px"><i class="fa fa-info"></i></a>
                            </span>
                          
                        </div>
                        @if ($errors->has('password'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('password')}}</strong></span>
                          @endif
                      </div>

                      
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align resize-margin-top" for="user_roles">Rol<span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6">
                          <select class="chosen" id="user_roles" name="user_roles" >
                            
                            @foreach($roles as $list)

                              @if($usuario->IdRol==$list->IdRol)
                                <option value="{{$list->IdRol}}">{{$list->Rol}}</option>
                              @endif
                            
                            @endforeach
                          </select>
                          @if ($errors->has('user_roles'))
                          <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('user_roles')}}</strong></span>
                          @endif
                        </div>
                      </div>




                      </div>
                    
                      
                      
                      <div class="form-group">
                        <div class="col-md-6 offset-md-6 margin-top-10">
                          <a href="{{url('/home')}}" class="btn btn-danger" style="padding: 0 8px"><i class="fa fa-home" style="margin-right: 5px"></i>Inicio</a>
                          <button id="send" type="submit" class="btn btn-success" style="padding: 0 8px"><i class="fa fa-refresh" style="margin-right: 5px"></i>Actualizar</button>
                        </div>
                      </div>
                    </form>

                    <p><i><strong>Campos Obligatorios (*)</strong></i></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
@endsection

@section('js')
  {{--  Js de la hoja --}}
  <script src="{{asset('js/jsApp/perfil.js')}}"></script>
@endsection
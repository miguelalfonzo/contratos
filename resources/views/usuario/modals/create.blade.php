<style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 

</style>

<div class="modal-content">
                  <form method="POST" id="form_user"  enctype="multipart/form-data">
                    
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                  <div class="modal-header">
                          <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>@if(isset($list[0]['id'])) Editar @else Nuevo @endif Usuario</span></h6>

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">

                      <div class="col-md-4 col-sm-12">
                        <div class="text-center">
                          <?php
                            
                            $imagen =(!empty($list[0]['Imagen']))?'profiles/'.$list[0]['Imagen']:'img/noimage.png';
                          ?>
                        <img id="preview" src="{{asset($imagen)}}" style="border-radius: 50%" height="150" width="150">
                        <input type="file" id="setImage" name="setImage" style="display: none">
                        </div>
                        <div class="text-center " style="margin-top: 20px">
                          <a href="javascript:changeProfile();" class="badge badge-primary">Cambiar</a>
                          <a href="javascript:removeImage()" class="badge badge-danger">Eliminar</a>
                          <input type="hidden" style="display: none" value="0" name="remove" id="remove"> 
                        </div>
                      </div>
                      

                      <div class="col-md-8 col-sm-12">
                      <div class="form-group row ">
                        
                        <div class="col-12 rounded bg bg-primary" style="margin-bottom:10px">
                          <h6 class="text-white p-0 m-0">Información General</h6>
                        </div>
                        
                        <input type="hidden" id="user_id" name="user_id" value="{{$list[0]['id'] ?? 0}}">


                         <label class="control-label col-md-4 col-sm-4 margin-top-10">Nombres</label>

                        <div class="col-md-8 col-sm-8 margin-top-10">
                        
                          
                      
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Nombres" id="user_nombre" name="user_nombre" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="{{$list[0]['Nombres']??''}}">
                          </div>

  
                        </div>
                        
                        
                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Apellido Paterno</label>

                        <div class="col-md-8 col-sm-8 margin-top-10">

                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm" placeholder="A.Paterno" id="ape_pat" name="ape_pat" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="{{$list[0]['Apellido_Paterno']??''}}">
                          </div>


                        </div>
                        
                        

                      </div>

                      <div class="form-group row resize-margin-top">
                        
                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Apellido Materno</label>

                        <div class="col-md-8 col-sm-8 margin-top-10">

                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="A.Materno" id="ape_mat" name="ape_mat" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="{{$list[0]['Apellido_Materno']??''}}">
                          </div>



                        </div>
                        
                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Correo Contacto</label>

                        <div class="col-md-8 col-sm-8 margin-top-10">

                      
                           <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">@</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Email Contacto" id="email_contacto" name="email_contacto" autocomplete="off" maxlength="100" value="{{$list[0]['EmailContacto']??''}}">
                          </div>



                        </div>

                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Celular</label>
                        <div class="col-md-8 col-sm-8 margin-top-10">

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-mobile"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Celular" id="celular" name="celular" onkeypress="return validateNumber(event);" autocomplete="off" maxlength="11" value="{{$list[0]['Celular']??''}}">
                          </div>

                        </div>

                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Teléfono Fijo</label>
                        <div class="col-md-8 col-sm-8 margin-top-10">

                      
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-phone"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Tel.Fijo" id="fijo" name="fijo" onkeypress="return validateNumber(event);" autocomplete="off" maxlength="11" value="{{$list[0]['Fijo']??''}}">
                          </div>


                        </div>


                        
                        <label class="control-label col-md-4 col-sm-4 margin-top-10"> Estado</label>
                        <div class="col-md-8 col-sm-8 margin-top-10">
                          <select class="chosen" id="user_estado" name="user_estado">
                            
                                @foreach($estados as $values)

                                  <option value="{{$values->Valor}}" {{ $values->Valor == ($list[0]['flag_activo']??1) ? "selected":"" }}>{{$values->Descripcion}}</option>
                                    
                                @endforeach
                          </select>
                        </div>

                        
                      </div>
      
                      <div class="form-group row ">
                        
                        <div class="col-12 rounded bg bg-primary" style="margin-bottom: 10px">
                          <h6 class="text-white p-0 m-0" >Acceso</h6>
                        </div>
                        
                        
                        <label class="control-label col-md-4 col-sm-4 margin-top-10"> Email</label>

                        <div class="col-md-8 col-sm-8 margin-top-10">


                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">@</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Email" id="email" name="email" autocomplete="off" maxlength="100" value="{{$list[0]['email']??''}}">
                          </div>


                        </div>
                        
                        
                        <label class="control-label col-md-4 col-sm-4 margin-top-10"> Password</label>
                        
                        <div class="col-md-8 col-sm-8 margin-top-10">


                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-lock"></i></div>
                            </div>
                            <input type="password" class="form-control has-feedback-left form-control-sm disable-buton"  placeholder="Password" id="password" name="password" autocomplete="off" maxlength="8" value="{{$list[0]['password']??''}}" readonly>
                          </div>



                        </div>

                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Seleccione Rol</label>

                        <div class="col-md-8 col-sm-8 margin-top-10">
                          <select id="user_roles" name="user_roles" class="chosen">
                            <option value="">Seleccione un Rol</option>
                            @foreach($roles as $values)
                            
                             <option value="{{$values->IdRol}}" {{ $values->IdRol == ($list[0]['IdRol']??'') ? "selected":"" }}>{{$values->Rol}}</option>

                            @endforeach
                          </select>
                        </div>
                        
                 
                      </div>

                      </div>
        

                    </div>
                    </div>

                    @if(!isset($list[0]['id']))

                      <div class="col-md-12 col-sm-12" >
                          <p><strong><i>(*)A los usuarios nuevos se les enviará una contraseña autogenerada a su correo electrónico</i></p></strong>
                     </div>


                    @endif
                                        

                    <div class="modal-footer">
                      
                    
                      <button type="submit" id="salvar_user" class="btn btn-success resize-button" ><i class="fa fa-edit icon-right"></i>Aceptar</button>

                    </div>
                    </form>
              </div>


<script src="{{asset('js/jsApp/save_usuario.js')}}"></script>
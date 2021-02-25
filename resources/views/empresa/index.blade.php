@extends('layout')
@section('css') 
  <style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 

</style>
@endsection


@section('content')
<div class="right_col" role="main">
          <div class="">
          
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">

                    <div class="col-sm-6 col-md-6 padding-5" >
                    
                    <span class="badge badge-dark text-white badge-resize-font" >Empresa</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-lock icon-right"></i>Seguridad</small>

                    </div>


                    
                    

                    <div class="col-sm-6 col-md-6 padding-5">
                    <button  type="submit"  form="form_empresa" class="btn btn-primary resize-button float-right-button" id="btnActualizar"><i class="fa fa-edit mr-2" ></i><span class="text-white">Actualizar</span></button>

                  
                    </div>

                    
                    
                    


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                      {{Session::get('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif


                    @if(Session::has('error'))
                    <div class="alert alert-error alert-dismissible fade show mt-2" role="alert">
                      {{Session::get('error')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif


                    <form method="POST" id="form_empresa" class="form-horizontal form-label-left" action="{{url('/actualiza_empresa')}}">

                      @csrf

                      <input type="hidden" name="id_empresa" id="id_empresa" value="{{$empresa->IdEmpresa}}">


                      

                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ruc_compania">RUC <span class="required">(*)</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-10">
                          
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="RUC" id="ruc_compania" name="ruc_compania"  autocomplete="off" maxlength="11" value="{{old('ruc_compania',$empresa->RUC)}}">

                             


                          </div>
                          @if ($errors->has('ruc_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('ruc_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="emp_compania" class="col-form-label col-md-3 col-sm-3 label-align">Empresa<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                         

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-home"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Empresa" id="emp_compania" name="emp_compania"  autocomplete="off" maxlength="100" value="{{old('emp_compania',$empresa->Empresa)}}">

                            
                          </div>
                          @if ($errors->has('emp_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('emp_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label for="abrv_emp_compania" class="col-form-label col-md-3 col-sm-3 label-align">Abreviatura</label>
                        <div class="col-md-6 col-sm-6 col-10">
                          
                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-ellipsis-h"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Abreviatura" id="abrv_emp_compania" name="abrv_emp_compania"  autocomplete="off" maxlength="20" value="{{old('abrv_emp_compania',$empresa->EmpresaAbrev)}}">
                           
                          </div>
                           @if ($errors->has('abrv_emp_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('abrv_emp_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="direccion_compania" class="col-form-label col-md-3 col-sm-3 label-align">Dirección<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                          
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-paper-plane"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Dirección" id="direccion_compania" name="direccion_compania"  autocomplete="off" maxlength="100" value="{{old('direccion_compania',$empresa->Direccion)}}">
                           
                          </div>
                           @if ($errors->has('direccion_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('direccion_compania')}}</strong></span>
                            @endif

                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="telf1_compania" class="col-form-label col-md-3 col-sm-3 label-align">Teléfono 1</label>
                        <div class="col-md-6 col-sm-6 col-10">
                          


                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-phone"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Teléfono 1" id="telf1_compania" name="telf1_compania"  autocomplete="off" maxlength="11" value="{{old('telf1_compania',$empresa->Telefono1)}}">
                            
                          </div>
                          @if ($errors->has('telf1_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('telf1_compania')}}</strong></span>
                            @endif

                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="telf2_compania" class="col-form-label col-md-3 col-sm-3 label-align">Télefono 2</label>
                        <div class="col-md-6 col-sm-6 col-10">
                          

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-phone"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Teléfono 2" id="telf2_compania" name="telf2_compania"  autocomplete="off" maxlength="11" value="{{old('telf2_compania',$empresa->Telefono2)}}">
                            
                          </div>

                          @if ($errors->has('telf2_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('telf2_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label for="mov1_compania" class="col-form-label col-md-3 col-sm-3 label-align">Móvil 1</label>
                        <div class="col-md-6 col-sm-6 col-10">
                          

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-mobile"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Móvil 1" id="mov1_compania" name="mov1_compania"  autocomplete="off" maxlength="11" value="{{old('mov1_compania',$empresa->Movil1)}}">
                            
                          </div>
                          @if ($errors->has('mov1_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('mov1_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="mov2_compania" class="col-form-label col-md-3 col-sm-3 label-align">Móvil 2</label>
                        <div class="col-md-6 col-sm-6 col-10">
                          

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-mobile"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Móvil 2" id="mov2_compania" name="mov2_compania"  autocomplete="off" maxlength="11" value="{{old('mov2_compania',$empresa->Movil2)}}">
                            
                          </div>
                          @if ($errors->has('mov2_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('mov2_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>
                      

                      <div class="item form-group">
                        <label for="fax_compania" class="col-form-label col-md-3 col-sm-3 label-align">Fax</label>
                        <div class="col-md-6 col-sm-6 col-10">
                         

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-fax"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Fax" id="fax_compania" name="fax_compania"  autocomplete="off" maxlength="20" value="{{old('fax_compania',$empresa->Fax)}}">
                            
                          </div>
                          @if ($errors->has('fax_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('fax_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="email_compania" class="col-form-label col-md-3 col-sm-3 label-align">Email<span class="required">(*)</span></label>
                        <div class="col-md-6 col-sm-6 col-10">
                          

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-envelope"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Email" id="email_compania" name="email_compania"  autocomplete="off" maxlength="50" value="{{old('email_compania',$empresa->EMail)}}">
                            
                          </div>
                          @if ($errors->has('email_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('email_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label for="url_compania" class="col-form-label col-md-3 col-sm-3 label-align">Web</label>
                        <div class="col-md-6 col-sm-6 col-10 ">
                          

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-link"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Web" id="url_compania" name="url_compania"  autocomplete="off" maxlength="100" value="{{old('url_compania',$empresa->URL)}}">
                            
                          </div>
                          @if ($errors->has('url_compania'))
                            <span class="text-danger" style="font-size:11px"><strong>{{ $errors->first('url_compania')}}</strong></span>
                            @endif
                        </div>
                      </div>
                      
                      
                      <div class="item form-group">
                        <label for="estado_compania" class="col-form-label col-md-3 col-sm-3 label-align">Estado</label>
                        <div class="col-md-6 col-sm-6 ">
                          <select class="chosen" id="estado_compania" name="estado_compania">
                            
                            @foreach($estados as $values)

                                  <option value="{{$values->Valor}}" {{ $values->Valor == ($empresa->FlagActivo??1) ? "selected":"" }}>{{$values->Descripcion}}</option>
                                    
                                @endforeach
                            </select>
                        </div>
                      </div>

                  
                    </form>
                  </div>
                </div>
              </div>
            </div>
</div>
</div>
@endsection
@section('js')

 
@endsection
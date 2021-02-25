@extends('layout')
@section('css')

<style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 

</style>
@endsection
@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

            <form method="POST" action="" id="form_obra">

            <meta name="csrf-token" content="{{ csrf_token() }}" />

            <div class="row">

             

             <div class="col-lg-6 col-md-6 col-sm-8">
               <h6 ><span class="badge badge-dark"><i class="fa fa-user mr-1"></i>@if(isset($obra[0]['IdObra']))Editar Obra - {{$obra[0]['Descripcion']}}@else Nueva Obra @endif</span></h6>
             </div>

             <div class="col-lg-6 col-md-6 col-sm-4">
               <button type="submit" class="btn btn-primary btn-sm resize-button float-right-button" ><i class="fa fa-save mr-1"></i>Guardar</button>

                    <a class="btn btn-danger btn-sm resize-button float-right-button" href={{url('/obras')}} ><i class="fa fa-chevron-circle-left mr-1"></i>Atras</a>
             </div>


               <div class="col-lg-7 col-md-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h6 class="d-inline">Datos de Obra</h6>
                  


                  

                  
                  <div class="clearfix"></div>
                </div>
                
                <div class="x_content">
                 

                   <div class="form-group row ">

                      <input type="hidden" name="hidden_id_obra" id="hidden_id_obra" value="{{$obra[0]['IdObra'] ?? 0}}">

                      <label class="control-label col-md-3 col-sm-3 ">Código</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <div class="input-group mb-2 mr-sm-2 ">
                          <div class="input-group-prepend ">
                            <div class="input-group-text " style="height:31px">#</div>
                          </div>
                          <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="obra_codigo" name="obra_codigo" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['CodigoObra'] ?? ''}}" readonly="true">
                        </div>
                      </div>
                   
                  </div>

                   <div class="form-group row resize-margin-top-12">


                      <label class="control-label col-md-3 col-sm-3 ">Nombre</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <div class="input-group mb-2 mr-sm-2 ">
                          <div class="input-group-prepend ">
                            <div class="input-group-text " style="height:31px"><i class="fa fa-home"></i></div>
                          </div>
                          <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="obra_nombre" name="obra_nombre" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['Descripcion'] ?? ''}}">
                        </div>
                      </div>
                   
                  </div>


                  <div class="form-group row resize-margin-top-12">


                      <label class="control-label col-md-3 col-sm-3 ">Ubigeo</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <div class="input-group mb-2 mr-sm-2 ">
                          <div class="input-group-prepend ">
                            <div class="input-group-text " style="height:31px"><i class="fa fa-thumb-tack"></i></div>
                          </div>

                          <input type="hidden" name="hidden_obra_idubigeo" id="hidden_obra_idubigeo" value="{{$obra[0]['Ubigeo'] ?? ''}}">

                          <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="obra_ubigeo" name="obra_ubigeo" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['FullUbigeo'] ?? ''}}">

                          <div id="ubigeo_list" class="list-autocompletar"></div>
                        </div>
                      </div>
                   
                  </div>

                  

                   <div class="form-group row resize-margin-top-12">


                      <label class="control-label col-md-3 col-sm-3 ">Cliente</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <div class="input-group mb-2 mr-sm-2 ">
                          <div class="input-group-prepend ">
                            <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                          </div>

                          <input type="hidden" name="hidden_obra_idcliente" id="hidden_obra_idcliente" value="{{$obra[0]['IdCliente'] ?? 0}}">


                          <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="obra_cliente" name="obra_cliente" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['ClienteName'] ?? ''}}">

                          <div id="clientes_list" class="list-autocompletar"></div>

                        </div>
                      </div>
                   
                  </div>

                  
                  
                  <div class="form-group row resize-margin-top-12">


                      <label class="control-label col-md-3 col-sm-3 ">Beneficiario</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <div class="input-group mb-2 mr-sm-2 ">
                          <div class="input-group-prepend ">
                            <div class="input-group-text " style="height:31px"><i class="fa fa-male"></i></div>
                          </div>

                          <input type="hidden" name="hidden_obra_idcontratante" id="hidden_obra_idcontratante" value="{{$obra[0]['IdContratante'] ?? 0}}">
                          <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="obra_beneficiario" name="obra_beneficiario" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['BeneficiarioName'] ?? ''}}">
                          <div id="beneficiario_list" class="list-autocompletar"></div>
                        </div>
                      </div>
                   
                  </div>

                  <div class="form-group row resize-margin-top-12">


                      <label class="control-label col-md-3 col-sm-3 ">Financia</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <div class="input-group mb-2 mr-sm-2 ">
                          <div class="input-group-prepend ">
                            <div class="input-group-text " style="height:31px"><i class="fa fa-male"></i></div>
                          </div>

                          <input type="hidden" name="hidden_obra_idfinanciero" id="hidden_obra_idfinanciero" value="{{$obra[0]['IdFinanciera'] ?? 0}}">

                          <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="obra_financia" name="obra_financia" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['FinancieraName'] ?? ''}}">

                          <div id="financiera_list" class="list-autocompletar"></div>
                        </div>
                      </div>
                   
                  </div>

                  <div class="form-group row resize-margin-top-12 mb-0">


                      <label class="control-label col-md-3 col-sm-3 ">Descripción</label>
                      <div class="col-md-9 col-sm-9 ">
                        
                       <textarea  class="form-control has-feedback-left form-control-sm"  placeholder="" id="obra_descripcion"  name="obra_descripcion" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" style="height:100px;resize: none;padding-left: 5px !important;">{{$obra[0]['DescripcionLarga'] ?? ''}}
                          </textarea>
                      </div>
                   
                  </div>

                </div>
              </div>
              
            </div>   


              <div class="col-lg-5 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h6 class="d-inline">Datos Complementarios</h6>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                     <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Ingreso</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <input type="date" id="obra_ingreso" name="obra_ingreso"class="form-control "  value="{{$obra[0]['FechaRegistro'] ?? date('Y-m-d')}}" required>
                        </div>
                     
                    </div>

                     <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Moneda</label>
                        <div class="col-md-9 col-sm-9 ">
                          <select class="chosen" id="obra_moneda" name="obra_moneda">
                            @foreach($monedas as $list)

                            <option value="{{$list->Valor}}" {{ $list->Valor == ($obra[0]['CodigoMoneda']??'') ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                            @endforeach
                         </select>
                         
                        </div>
                     
                    </div>

                    <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Monto</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-money"></i></div>
                            </div>
                            <input style=""type="text" class="validanumeros form-control has-feedback-left form-control-sm"  placeholder=""id="obra_monto" name="obra_monto" autocomplete="off" maxlength="100"  value="{{$obra[0]['Monto'] ?? ''}}" >
                          </div>
                        </div>
                        
                     
                    </div>
                    
                  <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Inicio</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <input type="date" id="obra_inicio" name="obra_inicio"class="form-control"  value="{{$obra[0]['FechaInicio'] ?? date('Y-m-d')}}" required>
                        </div>
                     
                    </div>

                    <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Dias</label>
                        <div class="col-md-3 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            
                            <input style=""type="text" class="numerosenteros form-control has-feedback-left form-control-sm"  placeholder="" id="obra_dias" name="obra_dias"   autocomplete="off" maxlength="3"  value="{{$obra[0]['Dias'] ?? ''}}">
                          </div>
                        </div>

                        <label class="control-label col-md-2 col-sm-3 " style="text-decoration: right">Fin</label>
                        <div class="col-md-4 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                           
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="obra_fin" name="obra_fin" autocomplete="off" maxlength="100"  value="{{$obra[0]['FechaFin'] ?? ''}}" readonly="true">
                          </div>
                        </div>
                     
                    </div>
                    
                    <div class="form-group row  resize-margin-top">

  
                        <label class="control-label col-md-3 col-sm-3 ">Condición</label>
                        <div class="col-md-9 col-sm-9 ">
                          <select class="chosen" id="obra_condicion" name="obra_condicion">
                           

                            @foreach($condicion as $list)

                            <option value="{{$list->Valor}}" {{ $list->Valor == ($obra[0]['IdCondicion']??'') ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                            @endforeach
                         </select>
                         
                        </div>
                     
                    </div>

                  
                 



                  </div>
                </div>
                
              </div>

              


              {{-- <div class="col-lg-12 col-md-12 ">
                <div class="x_panel">
                 
                
                
                  <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist" style="margin-top: -5px">
                      <li class="nav-item" >
                        <a class="nav-link active" id="representante-tab" data-toggle="tab" href="#representante" role="tab" aria-controls="representante" aria-selected="true">Docuemntos Asociados</a>
                      </li>
                      
                      
                    </ul>
                    <div class="tab-content" >
                      <div class="tab-pane fade show active" id="representante" role="tabpanel" aria-labelledby="representante-tab">
                      
                      @include('obra.tab.doc_asociados')
                      </div>

                    

                     
                    </div>


                  </div>
                
                  
                </div>
                
              </div> --}}
              


                </div>

              </form>

            </div>
          </div>
        </div>
        <!-- /page content -->
@endsection

@section('js')



{{--  js de la hoja --}}
  <script src="{{asset('js/jsApp/obra.js')}}"></script>
  
@endsection
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

            <form  method="POST" action="" id="form_cliente">

              <meta name="csrf-token" content="{{ csrf_token() }}" />

            <div class="row">

              <div class="col-lg-6 col-md-6 col-sm-8">
               <h6 ><span class="badge badge-dark"><i class="fa fa-user mr-1"></i>@if(isset($cliente->IdCliente))Editar Cliente - {{$cliente->Nombre}}@else Nuevo Cliente @endif</span></h6>
             </div>

             <div class="col-lg-6 col-md-6 col-sm-4">
               <button type="submit" id="btn_guardar_cliente" class="btn btn-success btn-sm resize-button float-right-button" ><i class="fa fa-save mr-1"></i>Guardar</button>
                    <a class="btn btn-danger btn-sm resize-button float-right-button" href={{url('/clientes')}} ><i class="fa fa-chevron-circle-left mr-1"></i>Atras</a>
             </div>

              <div class="col-lg-7 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h6 class="d-inline">Datos del Cliente</h6>
                    


                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    

                    <div class="form-group row ">
                      <input type="hidden" name="cliente_id_empresa" id="cliente_id_empresa" value="{{$cliente->IdCliente ?? 0}}">
                      

                      <input type="hidden" name="cliente_id_consorcio" id="cliente_id_consorcio" value="{{$cliente->IdConsorcio ?? 0}}">


                        <label class="control-label col-md-2 col-sm-2  ">Documento</label>
                        <div class="col-md-4 col-sm-4  ">
                          
                         <select class="chosen" id="cliente_documento" name="cliente_documento">
                           @foreach($documentos as $list)

                            <option value="{{$list->Valor}}" {{ $list->Valor == ($cliente->CodigoDocumento??'') ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                            @endforeach
                         </select>
                        </div>


                        <label class="control-label col-md-2 col-sm-2 ">N°Doc(*)</label>
                        <div class="col-md-4 col-sm-4 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <!-- <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div> -->

                            
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="cliente_identificacion" name="cliente_identificacion" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="15"  value="{{$cliente->Identificacion ?? ''}}">

                            <?php
                                if(isset($cliente->IdCliente)){

                                  if($cliente->CodigoDocumento=="RC" || $cliente->CodigoDocumento=="DI"){

                                    $show="block";

                                  }else{

                                     $show ='none';
                                  }

                                }else{

                                  $show ='block';
                                }
                            ?>
                            <span class="input-group-btn" style="height:31px;display: <?php echo $show;?>" id="span_find_ruc">
                            <button type="button" class="btn btn-primary btn-sm "><i class="fa fa-search"></i></button>
                            </span>

                          </div>
                        </div>
                     

                        
                         




                    </div>

                     <div class="form-group row resize-margin-top-12 mt-1">

  
                        <label class="control-label col-md-3 col-sm-3 ">Razon Social</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-home"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="cliente_rsocial" name="cliente_rsocial"  autocomplete="off" maxlength="100"  value="{{$cliente->RazonSocial ?? ''}}">
                          </div>
                        </div>
                     
                    </div>

                     <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Nombre Comercial(*)</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="cliente_ncomercial" name="cliente_ncomercial"  autocomplete="off" maxlength="100"  value="{{$cliente->Nombre ?? ''}}">
                          </div>
                        </div>
                     
                    </div>

                    
                    
                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Dirección</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-thumb-tack"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="cliente_direccion" name="cliente_direccion" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$cliente->Direccion ?? ''}}">
                          </div>
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Referencia</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-thumb-tack"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="cliente_referencia" name="cliente_referencia" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$cliente->ReferenciaUbicacion ?? ''}}">
                          </div>
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12 mb-0">

  
                        <label class="control-label col-md-3 col-sm-3 ">Ubigeo</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-thumb-tack"></i></div>
                            </div>

                            <input type="hidden" name="cliente_id_ubigeo" id="cliente_id_ubigeo" value="{{$cliente->Ubigeo  ?? ''}}">
                            
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="cliente_ubigeo" name="cliente_ubigeo" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$cliente->DPTO  ?? ''}} {{$cliente->PROV  ?? ''}} {{$cliente->DIST  ?? ''}}">

                            <div id="ubigeo_list" class="list-autocompletar">
                          </div>

                          </div>
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
                          
                         <input type="date" id="cliente_ingreso" name="cliente_ingreso"class="form-control resize-input disable-buton" readonly value={{$cliente->FechaIngreso ?? date('Y-m-d')}}>
                        </div>
                     
                    </div>

                     <!-- <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Moneda</label>
                        <div class="col-md-9 col-sm-9 ">
                          <select class="chosen" id="cliente_moneda" name="cliente_moneda">
                           @foreach($monedas as $list)

                            <option value="{{$list->Valor}}" {{ $list->Valor == ($cliente->CodigoMoneda??'') ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                            @endforeach
                         </select>
                         
                        </div>
                     
                    </div> -->

                    <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Estado</label>
                        <div class="col-md-9 col-sm-9 ">
                          <select class="chosen" id="cliente_estado" name="cliente_estado">
                           @foreach($estados as $list)

                            <option value="{{$list->Valor}}"{{ $list->Valor == ($cliente->FlagActivo??1) ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                            @endforeach
                         </select>
                         
                        </div>
                     
                    </div>
                    
                  <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">T.Cliente</label>
                        <div class="col-md-9 col-sm-9 ">
                          <select class="chosen" id="tipo_cliente" name="tipo_cliente">
                           @foreach($tipo_cliente as $list)

                            <option value="{{$list->Valor}}"{{ $list->Valor == ($cliente->IdTipoCliente??'') ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                            @endforeach
                         </select>
                         
                        </div>
                     
                    </div>

                    <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Actividad</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:28px"><i class="fa fa-location-arrow"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm font-size-12"  placeholder="" id="cliente_actividad" name="cliente_actividad" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$cliente->Ocupacion ?? ''}}">
                          </div>
                        </div>
                     
                    </div>
                    
                    <div class="form-group row  resize-margin-top">

  
                        <label class="control-label col-md-3 col-sm-3 ">PD BOX</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm disable-buton"  placeholder="" id="pdo_box_cliente" name="pdo_box_cliente" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="" readonly>
                          </div>
                        </div>

                        
                     
                    </div>


                 
                  <div class="form-group row  resize-margin-top" id="btn_empresas_consorcios" style="<?php if(isset($cliente->IdCliente)){if($cliente->IdTipoCliente=="05"){echo 'display: block';}else{echo 'display: none';}}else{echo 'display: none';}?>">

  
                        <label class="control-label col-md-3 col-sm-3 "></label>
                        <div class="col-md-9 col-sm-9 ">
                          <a href="" class="btn btn-dark resize-button btn-sm" onclick="prepara_modal_consorcio(); return false;"><i class="fa fa-home mr-2"  id="btn_modal_agregar_empresas"></i>Ver Empresas</a>
                         
                        </div>

                        
                     
                    </div>



                  </div>
                </div>
                
              </div>


              <div class="col-lg-12 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">

                    <div class="col-lg-4 col-md-4 margin-top-5">
                    <h6 class="d-inline">Datos Contacto</h6>
                    </div>


                    <div class="col-lg-6 col-md-6 margin-top-5">
                    <input type="text" placeholder="Buscar..." class="form-control-sm form-control" id="search_table_contatos" >
                    </div>

                    <div class="col-lg-2 col-md-2 margin-top-5">
                    <button class="btn btn-primary btn-sm resize-button " id="btn_agregar_contacto" style="float: right;"><i class="fa fa-plus mr-1"></i>Contacto</button>
                    </div>

                    

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    

                    <div class="form-group row ">
                      
                      <table id="tabla_cliente_contactos"class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                           <thead>
                             <tr>
                               <th>Contacto</th>
                               <th>Telefono</th>
                               <th>Celular</th>
                               <th>Email</th>
                               <th><i class="fa fa-edit"></i></th>
                               <th style="display: none">id</th>
                             </tr>
                           </thead>
                           <tbody>
                             @foreach($cliente_contactos as $list)

                              <tr>
                                <td>{{$list->Contacto}}</td>
                                <td>{{$list->TelefonoContacto}}</td>
                                <td>{{$list->CelularContacto}}</td>
                                <td>{{$list->MailContacto}}</td>
                                <td><a class="text-success  btn-icon " onclick="set_parametros_contacto('{{$list->IdClienteContacto}}')"><i class="fa fa-edit mr-2"></i></a><a class=" text-danger btn-icon" onclick="elimina_contacto('{{$list->IdClienteContacto}}')"><i class="fa fa-close"></i></a></td>
                                <td style="display: none">{{$list->IdClienteContacto}}</td>
                              </tr>
                             @endforeach
                           </tbody>
                         </table>
                    </div>
                    

                  
                 



                  </div>
                </div>
                
              </div>
              


              {{-- <div class="col-lg-12 col-md-12 ">
                <div class="x_panel">
                 
                
                
                  <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs " id="myTab" role="tablist" style="margin-top: -5px">
                      <li class="nav-item" >
                        <a class="nav-link active" id="representante-tab" data-toggle="tab" href="#representante" role="tab" aria-controls="representante" aria-selected="true">Representantes</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="accionista-tab" data-toggle="tab" href="#accionista" role="tab" aria-controls="accionista" aria-selected="false">Accionistas</a>
                      </li>

                      </li>
                       <li class="nav-item">
                        <a class="nav-link" id="documento-tab" data-toggle="tab" href="#documento" role="tab" aria-controls="documento" aria-selected="false">Documentos</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="financiera-tab" data-toggle="tab" href="#financiera" role="tab" aria-controls="financiera" aria-selected="false">Financieras</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="obra-tab" data-toggle="tab" href="#obra" role="tab" aria-controls="obra" aria-selected="false">Obras</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="fianza-tab" data-toggle="tab" href="#fianza" role="tab" aria-controls="fianza" aria-selected="false">Fianzas</a>
                      </li>

                      <li class="nav-item">
                        <a class="nav-link" id="solicitud-tab" data-toggle="tab" href="#solicitud" role="tab" aria-controls="solicitud" aria-selected="false">Solicitudes</a>
                      </li>
                      
                       <li class="nav-item">
                        <a class="nav-link" id="llamada-tab" data-toggle="tab" href="#llamada" role="tab" aria-controls="llamada" aria-selected="false">Llamadas</a>
                      </li>


                      <li class="nav-item">
                        <a class="nav-link" id="consorcio-tab" data-toggle="tab" href="#consorcio" role="tab" aria-controls="consorcio" aria-selected="false">Consorcios</a>
                      </li>
                      
                    </ul>
                    <div class="tab-content" >
                      <div class="tab-pane fade show active" id="representante" role="tabpanel" aria-labelledby="representante-tab">
                      
                      @include('cliente.tabs.representantes')
                      @include('cliente.modals.representante')
                      </div>

                      <div class="tab-pane fade" id="accionista" role="tabpanel" aria-labelledby="accionista-tab">
                      @include('cliente.tabs.accionistas')
                      </div>

                      <div class="tab-pane fade" id="documento" role="tabpanel" aria-labelledby="documento-tab">
                      @include('cliente.tabs.documentos')
                      </div>

                      <div class="tab-pane fade" id="financiera" role="tabpanel" aria-labelledby="financiera-tab">
                      @include('cliente.tabs.financieras')
                      </div>

                      <div class="tab-pane fade" id="obra" role="tabpanel" aria-labelledby="obra-tab">
                     @include('cliente.tabs.obras')
                      </div>

                      <div class="tab-pane fade" id="fianza" role="tabpanel" aria-labelledby="fianza-tab">
                     @include('cliente.tabs.fianzas')
                      </div>

                      <div class="tab-pane fade" id="solicitud" role="tabpanel" aria-labelledby="solicitud-tab">
                     @include('cliente.tabs.solicitudes')
                      </div>


                      <div class="tab-pane fade" id="llamada" role="tabpanel" aria-labelledby="llamada-tab">
                     @include('cliente.tabs.llamadas')
                      </div>

                      <div class="tab-pane fade" id="consorcio" role="tabpanel" aria-labelledby="consorcio-tab">
                     @include('cliente.tabs.consorcios')
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
@include('cliente.modals.contactos')
@include('cliente.modals.empresas')
@endsection

@section('js')



{{--  js de la hoja --}}
  <script src="{{asset('js/jsApp/clientes.js')}}"></script>
  
@endsection
@extends('layout')
@section('css')

<style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 

</style>

<link href="{{asset('vendors/switchery/dist/switchery.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <div class="clearfix"></div>

             <form  method="POST" action="" id="form_solicitud">

           <!--  <div class="row"> -->

              <div class="col-lg-6 col-md-6 col-sm-8">
               <h6 ><span class="badge badge-dark"><i class="fa fa-user mr-1"></i>Solicitud - Obra : {{$obra[0]['Descripcion']??''}}</span></h6>
             </div>

             <div class="col-lg-6 col-md-6 col-sm-4">
               <button type="submit" id="" class="btn btn-success btn-sm resize-button float-right-button" ><i class="fa fa-save mr-1"></i>Tramitar</button>
                    <a class="btn btn-danger btn-sm resize-button float-right-button" href="{{url('/obras')}}" ><i class="fa fa-chevron-circle-left mr-1"></i>Atras</a>
             </div>

            

              <meta name="csrf-token" content="{{ csrf_token() }}" />
              
              <input type="hidden" name="solicitud_id" id="solicitud_id" value="{{$solicitud[0]['IdCartaFianza'] ?? 0}}">


              <input type="hidden" name="solicitud_id_obra" id="solicitud_id_obra" value="{{$obra[0]['IdObra'] ?? 0}}">

              <input type="hidden" name="solicitud_id_cliente" id="solicitud_id_cliente" value="{{$obra[0]['IdCliente'] ?? 0}}">

              <input type="hidden" name="solicitud_id_beneficiario" id="solicitud_id_beneficiario" value="{{$obra[0]['IdContratante'] ?? 0}}">

              <input type="hidden" name="solicitud_id_financia" id="solicitud_id_financia" value="{{$obra[0]['IdFinanciera'] ?? 0}}">


              <div class="col-lg-6 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h6 class="d-inline">Datos Obra</h6>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                      <div class="form-group row ">

                        <label class="control-label col-md-2 col-sm-2 ">Núm.Doc</label>
                        <div class="col-md-4 col-sm-4 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_identificacion" name="solicitud_identificacion" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="15"  value="{{trim($obra[0]['ClienteNumDoc']) ?? ''}}" readonly>
                          </div>
                        </div>
                     

                        <label class="control-label col-md-2 col-sm-2  ">Estado</label>
                        <div class="col-md-4 col-sm-4  ">
                          
                         <select class="chosen" id="solicitud_estado" name="solicitud_estado">
                           @foreach($estados as $list)

                              <option value="{{$list->Valor}}" {{ $list->Valor == ($solicitud[0]['EstadoSol']??'PND') ? "selected":"" }}>{{$list->Descripcion}}</option>

                              
                                    
                            @endforeach
                         </select>


                         

                        </div>

                         
                    </div>

                     <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Razon Social</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-home"></i></div>
                            </div>
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_rsocial" name="solicitud_rsocial" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['ClienteName'] ?? ''}}" readonly>
                          </div>
                        </div>
                     
                    </div>

                     <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Contratante</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_contratante" name="solicitud_contratante" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="15"  value="{{$obra[0]['BeneficiarioName'] ?? ''}}" readonly>
                          </div>
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Fecha</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                           <input type="date" id="solicitud_fecha" name="solicitud_fecha"class=" form-control "  value="{{$obra[0]['FechaRegistro'] ?? date('Y-m-d')}}" style="height:31px" required>

                          </div>
                        </div>
                     
                    </div>

                  </div>
                </div>
                
              </div>

             

              <div class="col-lg-6 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h6 class="d-inline">Datos Complementarios</h6>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    
                    <div class="form-group row ">

  
                        <label class="control-label col-md-3 col-sm-3 ">Solicitud</label>
                        

                       

                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_solicitud_key" name="solicitud_solicitud_key" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$solicitud[0]['CodigoSolicitud'] ?? ''}}" readonly>
                          </div>
                        </div>
                     
                     
                    </div>

                     <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Código Obra</label>

                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_cod_obra" name="solicitud_cod_obra" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" value="{{$obra[0]['CodigoObra'] ?? ''}}" readonly>
                          </div>
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Moneda</label>
                        <div class="col-md-3 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_moneda" name="solicitud_moneda"   autocomplete="off" maxlength="10"  value="{{$obra[0]['CodigoMoneda'] ?? ''}}" readonly>
                          </div>
                        </div>

                        <label class="control-label col-md-2 col-sm-3 " style="text-decoration: right">Monto</label>
                        <div class="col-md-4 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                           
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_monto" name="solicitud_monto" autocomplete="off" maxlength=""  value="{{number_format($obra[0]['Monto'], 2, '.', ',') ?? 0}}" readonly>

                          </div>
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-3 col-sm-3 ">Departamento</label>

                        <div class="col-md-9 col-sm-9 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-thumb-tack"></i></div>
                            </div>
                            <input style=""type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="solicitud_departamento" name="solicitud_departamento" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$obra[0]['Localidad'] ?? ''}}" readonly>
                          </div>
                        </div>
                     
                    </div>

                    </div>

                  </div>
                </div>
                
              
              

              <!-- para subir documentos -->

              <div class="col-lg-6 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">

                    <h6 class="d-inline">Gestión de Cartas Fianzas</h6>

                     <label>
                       
                     </label>                     

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <div class="form-group row ">

  
                        <label class="control-label col-md-5 col-sm-3 "><button type="button" data-type="fc" class="EliminaFianzaBtn btn btn-danger btn-sm resize-button px-1">x</button>&nbsp;Fiel Cumplimiento</label>
                        <div class="input-group col-md-7 col-sm-9 ">
                          <label>
                        <input class="js-switch" type="checkbox" id="switch_cumplimiento" name="switch_cumplimiento">&nbsp;&nbsp;
                         </label>
                         <input style="" type="text" class="form-control has-feedback-left form-control-sm ml-2"  placeholder="" id="solicitud_cumplimiento" name="solicitud_cumplimiento" oninput='limitDecimalPlaces(event, 2)' onkeyup='recalcula_fianza()' onkeypress='return isNumberKey(event)' value="{{ $obra[0]['FielCumplimiento'] ?? ''}}" readonly>
                        
                         
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-5 col-sm-3 "><button data-type="ad" type="button" class="EliminaFianzaBtn btn btn-danger btn-sm resize-button px-1">x</button>&nbsp;Adelanto Directo</label>
                        <div class="input-group col-md-7 col-sm-9 ">
                          <label>
                        <input class="js-switch" type="checkbox" id="switch_directo" name="switch_directo" >&nbsp;&nbsp;
                      </label>
                      
                         <input style="" type="text" class="form-control has-feedback-left form-control-sm ml-2 "  placeholder="" id="solicitud_directo" name="solicitud_directo" oninput='limitDecimalPlaces(event, 2)' onkeyup='recalcula_fianza()' onkeypress='return isNumberKey(event)'  value="{{$obra[0]['AdelantoDirecto'] ?? ''}}" readonly>
                        
                        
                        </div>
                     
                    </div>

                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-5 col-sm-3 "><button type="button" data-type="am" class="EliminaFianzaBtn btn btn-danger btn-sm resize-button px-1">x</button>&nbsp;Adelanto de Materiales</label>
                        <div class="input-group col-md-7 col-sm-9 ">
                          <label>
                          <input class="js-switch" type="checkbox" id="switch_materiales" name="switch_materiales" >&nbsp;&nbsp;
                          </label>
                         <input style="" type="text" class="form-control has-feedback-left form-control-sm ml-2"  placeholder="" id="solicitud_materiales" name="solicitud_materiales" oninput='limitDecimalPlaces(event, 2)' onkeyup='recalcula_fianza()' onkeypress='return isNumberKey(event)'  value="{{$obra[0]['AdelantoMateriales'] ?? '' }}" readonly="">
                         
                        </div>
                     
                    </div>


                    <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-5 col-sm-3 ">Total Fianza </label>
                        <div class="input-group col-md-7 col-sm-9 " style="padding-left:50px">
                          
                          <?php

                           $totalizado = $obra[0]['AdelantoMateriales']+$obra[0]['AdelantoDirecto']+$obra[0]['FielCumplimiento'];


                          ?>
                         <input style="background: #60F87A" type="text" class="disable-buton form-control has-feedback-left form-control-sm ml-2"  placeholder="" id="total_solicitud" name="total_solicitud" onkeypress="" autocomplete="off"  value="{{number_format($totalizado, 2, '.', ',')}}" readonly="">
                         

                         

                        </div>
                     
                    </div>


                    

                   
                    
                  </div>
                </div>
                
              </div>

              <div class="col-lg-6 col-md-12 ">
                <div class="x_panel">
                  <div class="x_title">

                    <h6 class="d-inline">Documentación Adjunta</h6>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                     <div class="card-box table-responsive" >

                           
                      <table id="table-solicitud-documentos" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                    
                        <thead>
                        <tr>
                          <th>Documento</th>
                          <th>Fecha Modificación</th>
                          <th>Accion</th>   
                                                             
                       </tr>
                      </thead>
                      
                     <tbody>
                       
                     </tbody>
                    
                      </table>
                      </div>




                  </div>

                    
                  </div>
                </div>

                </form>
              </div>

        
        </div>
      
        <!-- /page content -->

@include('solicitud.modals.documentos')
@include('solicitud.modals.documento_memoria')
@endsection

@section('js')

{{--  js de la hoja --}}
  <script src="{{asset('js/jsApp/solicitud.js')}}"></script>

  <script src="{{asset('vendors/switchery/dist/switchery.min.js')}}"></script>
  
@endsection
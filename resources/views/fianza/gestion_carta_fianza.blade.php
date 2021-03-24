@extends('layout')
@section('css') 

<!-- stetps -->
<link href="{{asset('vendors/steps/css/normalize.css')}}" rel="stylesheet">
<link href="{{asset('vendors/steps/css/main.css')}}" rel="stylesheet">
<link href="{{asset('vendors/steps/css/jquery.steps.css')}}" rel="stylesheet">

<!-- <style type="text/css">
  th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
 
</style> -->
@endsection

@section('content')
   <div class="right_col" role="main">
          <div class="">
            

            <div class="clearfix"></div>

            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="col-sm-6 col-md-3 padding-5" >
                    <span class="badge badge-dark text-white badge-resize-font">Gestión</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-sort-amount-asc icon-right"></i>Cartas Fianza</small>
                    </div>
                    
                    <input type="hidden"  id="DiasCobroChequeParamGral" value="{{$parametros_generales[0]->DiasCobroCheque}}">

                    <div class="col-sm-6 col-md-6  padding-5" >
                        

                          <a data-tipo='PE' class="filter-label-vencimiento btn btn-sm btn-success resize-button text-white" style="cursor: pointer"><small><i class="fa fa-calendar mr-1" ></i>Pendientes</small></a>

                           

                           <a data-tipo='VH' class="filter-label-vencimiento btn btn-sm btn-success resize-button text-white" style="cursor: pointer"><small><i class="fa fa-calendar mr-1" ></i>Vencen Hoy</small></a> 
                           

                           <a data-tipo='VE' class="filter-label-vencimiento btn btn-sm btn-success resize-button text-white" style="cursor: pointer"><small><i class="fa fa-calendar mr-1"></i>Vencidas</small></a> 
                           

                           <a data-tipo='PV' class="filter-label-vencimiento btn btn-sm btn-success resize-button text-white" style="cursor: pointer"><small><i class="fa fa-calendar mr-1"></i>Por Vencer</small></a>


                           <button id="btn_filtro_especial_fianzas" type="button" class="btn btn-sm resize-button btn-primary"><i class="fa fa-search mr-2"></i>Filtrar</button>                                       
                    </div>
                    
                    <div class="col-sm-9 col-md-3 padding-5">
                        <input type="text" id="buscador_general" name="buscador_general" class="form-control resize-input btn-round" placeholder="Buscar..." autocomplete="off">
                    </div>                  
                    


                  

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" >
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive resize-margin-top">
                          
                           <div class="col-12">
                               
                               <div class="col-lg-3">
                                <label class="control-label ">Cliente : </label> <strong><span id="filtro_cabecera_cliente" class="resize-span text-primary"></span></strong>
                               </div>

                               <div class="col-lg-3">
                                   <label class="control-label col-lg-4">Obra : </label> <strong><span id="filtro_cabecera_obra" class="resize-span text-primary"></span></strong>

                               </div>
                               
                               <div class="col-lg-3">

                                    <label class="control-label col-lg-4">Carta : </label> <strong><span id="filtro_cabecera_fianza" class="resize-span text-primary"></span></strong>

                               </div>

                               <div class="col-lg-3">

                                    <label class="control-label col-lg-4">Fianza : </label> <strong><span id="filtro_cabecera_vence" class="resize-span text-primary"></span></strong>

                               </div>

                           </div>     
                          <table id="tabla-fianza" class="margin-top-10 table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%"> 

                                <thead>
                                    <tr class="headings">
                                        <th style="width: 5%">N° Solicitud</th>
                                        <th style="width: 5%">File</th>
                                        <th style="width: 10%">Tipo Documento</th>
                                        <th style="width: 25%">Cliente</th>
                                        <th style="width: 25%">Obra</th>
                                            
                                          
                                        <th style="width: 5%">Monto</th>  
                                        <th style="width: 5%">Estado</th>  
                                        <th style="width: 5%">Acción</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                                
                                </tbody>
                                
                            </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            


@include('fianza.modals.modal_gestionar_carta')
@include('fianza.tabs_gestion.upload_documento_gestion')
@include('fianza.modals.modal_renovar_carta')
@include('fianza.modals.modal_renovar_garantias')
@include('fianza.modals.modal_cerrar_carta')
@include('fianza.modals.modal_ver_historial')
@include('fianza.modals.modal_filtro_fianzas')

{{-- avance de obra documento --}}
@include('fianza.tabs.avance_obra_documento')
@endsection

@section('js')  
<!-- Js de la hoja - gestionar carta-->
<script src="{{asset('js/jsApp/gestion_carta_fianza.js')}}"></script>


<!-- Js de la hoja - renovar carta-->
<script src="{{asset('js/jsApp/renovar_carta_fianza.js')}}"></script>


<!-- Js de la hoja - historial carta-->
<script src="{{asset('js/jsApp/historial_carta_fianza.js')}}"></script>

<!-- Js de la hoja - stetps-->

<script src="{{asset('vendors/steps/js/modernizr-2.6.2.min.js')}}"></script>
<!-- <script src="{{asset('vendors/steps/js/jquery-1.9.1.min.js')}}"></script> -->
<script src="{{asset('vendors/steps/js/jquery.cookie-1.3.1.js')}}"></script>
<script src="{{asset('vendors/steps/build/jquery.steps.js')}}"></script>
<!-- js ordenar por fecha tabla -->

<script src="{{asset('vendors/datetable_moment/moment.js')}}"></script>
<script src="{{asset('vendors/datetable_moment/datepicker_datetable.js')}}"></script>


<script>
$(function ()
    {
    $("#wizard").steps({
        headerTag: "h4",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        stepsOrientation: "horizontal",
        labels: { finish: "<span><i class='fa fa-refresh mr-2'></i>Fin</span>",
                next: "<span><i class='fa fa-mail-forward mr-2'></i>Siguiente</span>",
                previous: "<span><i class='fa fa-mail-reply mr-2'></i>Anterior</span>"}
                    });
                });


function reporte_pdf_historial(){


    const codigo_obra = $("#hist_num_interno").val();


    const url= server+'reporte_historial/'+codigo_obra;
    
    window.open(url, '_blank');
    
    return false;
}


</script>
@endsection
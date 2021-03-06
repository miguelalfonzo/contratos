@extends('layout')
@section('css') 

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
                    <span class="badge badge-dark text-white badge-resize-font">Clientes</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-cog icon-right"></i>Maestro</small>
                    </div>
                    
                    <div class="col-sm-6 col-md-4  padding-5" >
                        <label class="control-label col-xs-3 col-md-3 col-sm-3 margin-top-5">Estado:</label>
                            <div class="col-xs-7 col-md-6 col-sm-6 " >
                                <select class="chosen" id="filtro_cliente" name="filtro_cliente">
                                    <option value="2">TODOS</option>
                                    @foreach($estados as $list)

                                     <option value="{{$list->Valor}}" {{ $list->Valor == 1 ? "selected":"" }}>{{$list->Descripcion}}</option>
                                    
                                    @endforeach
                                </select>
                            </div>
                                       
                    </div>
                    
                    <div class="col-sm-9 col-md-3 padding-5">
                        <input type="text" id="buscador_general" name="buscador_general" class="form-control resize-input btn-round" placeholder="Buscar..." autocomplete="off">
                    </div>
                    
                    


                    <div class="col-sm-3 col-md-2 padding-5">
                        

                        <a class="btn btn-primary resize-button float-right-button" id="btn_modal_nuevo_cliente" href="{{url('/cliente')}}"><i class="fa fa-plus icon-right"></i>Nuevo</a>

                         

                    </div> 

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive resize-margin-top">
                          
                                
                          <table id="tabla-cliente" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%"> 

                                <thead>
                                    <tr class="headings">
                                        <th style="width: 10%">Identificación</th>
                                        <th style="width: 30%">Razon Social</th>
                                        <th style="width: 10%">Localidad</th>
                                        <th style="width: 20%">Tipo Cliente</th>
                                        <th style="width: 20%">Estado</th>
                                        <th style="width: 15%">Acción</th>    
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
            


@include('cliente.modals.representante')
@include('cliente.modals.accionista')
@include('cliente.modals.documentos')
@include('cliente.modals.empresas')
@endsection

@section('js') 	
<!-- Js de la hoja-->
<script src="{{asset('js/jsApp/list_cliente.js')}}"></script>

@endsection
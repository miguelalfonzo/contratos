@extends('layout')

@section('css') 
<link href="{{asset('css/principal.css')}}" rel="stylesheet">



<style>
	
</style>

@endsection


@section('content')

<div class="right_col" role="main"> 

  <div class="">

    <div class="">

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_title ">


            <div class="col-sm-4 col-md-4 col-lg-4 padding-5">




             <span class="badge badge-dark text-white badge-resize-font" >Obras</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-edit icon-right"></i>Lista de obras</small>                        


           </div> 

           <div class="col-sm-2 col-md-2 padding-5">
            <button id="btn_filtrar_obra" class="btn btn-dark btn-sm resize-button"><i class="fa fa-search mr-2"></i>filtrar</button>
          </div>

          <div class="col-sm-3 col-md-3 padding-5">
            <input type="text" id="buscador_general" name="buscador_general" class="form-control resize-input btn-round" placeholder="Buscar..." autocomplete="off">
          </div>


          <div class="col-sm-3 col-md-3 col-lg-3 padding-5"  >

            <a href="{{url('/obra')}}" class="m-0 p-0 px-2 btn btn-primary float-right"><i class="fa fa-plus"></i> Nueva Obra</a>
          </div>








          <div class="clearfix"></div>
        </div>


        <div class="x_content">      



         <!------------------tabla--------->

         <div class="row">

          <div class="col-12 resize-margin-top">
            <span><strong>Proceso :</strong></span>
            <span class="badge badge-success p-1" id="lblProcesoFilter">TODOS</span>&nbsp;&nbsp;&nbsp;
            <span><strong>Condición :</strong></span>
            <span class="badge badge-success p-1" id="lblCondicionFilter">TODOS</span>&nbsp;&nbsp;&nbsp;
            <span><strong>Cliente :</strong></span>
            <span class="badge badge-success p-1" id="lblClienteFilter">TODOS</span>&nbsp;&nbsp;&nbsp;
            <span><strong>Obra :</strong></span>
            <span class="badge badge-success p-1" id="lblObraFilter">TODOS</span>&nbsp;&nbsp;&nbsp;
            <span><strong>Inicio :</strong></span>
            <span class="badge badge-success p-1" id="lblInicioFilter"><?php echo date('Y-01-01');?></span>&nbsp;&nbsp;&nbsp;
            <span><strong>Fin :</strong></span>
            <span class="badge badge-success p-1" id="lblFinFilter"><?php echo date('Y-m-d');?></span>&nbsp;&nbsp;&nbsp;
          </div>

          <div class="col-sm-12">

            <div class="card-box table-responsive margin-top-10">


              <table id="table_obra" class="table tbl_out_margin jambo_table letra-size-tablas" style="width:100%">

                <thead>
                  <tr class="headings">

                    <th>Codigo Obra</th>
                    <th>Obra</th>
                    <th>Cliente</th>
                    <th>Beneficiario</th>
                    <th>Financiera</th>
                    <th>Localidad</th>
                    <th>Condición</th>
                    <th>Acciones</th>
                  </tr>
                </thead>




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

@include('obra.modals.documentos')
@include('obra.modals.rechaza_solicitud')
@include('obra.modals.filtrar_list_obras')
@endsection 

@section('js')


{{--  js de la hoja --}}
<script src="{{asset('js/jsApp/list_obra.js')}}"></script>



@endsection
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


                    <div class="col-sm-6 col-md-6 col-lg-6 padding-5">

	                     


                       <span class="badge badge-dark text-white badge-resize-font" >Obras</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-edit icon-right"></i>Lista de obras</small>                        


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
	                      <div class="col-sm-12">
                
                        <div class="card-box table-responsive resize-margin-top">
                          
                                
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
@endsection 

@section('js')


{{--  js de la hoja --}}
  <script src="{{asset('js/jsApp/list_obra.js')}}"></script>
  
@endsection
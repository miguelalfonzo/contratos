@extends('layout')
@section('css')
<style>
    
  td.details-control {
    background: url({{asset('img/details_open.png')}}) no-repeat center center;
    cursor: pointer;
  }

  tr.details td.details-control {
    background: url({{asset('img/details_close.png')}}) no-repeat center center;
  }
  
</style>

@endsection

@section('content')

   <div class="right_col" role="main">
          <div class="">
            

            <div class="clearfix"></div>

            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    
                    <span class="badge badge-dark text-white badge-resize-font">Ubigeo</span>&nbsp<small class="badge badge-info font-size-12"><i class="fa fa-cog icon-right"></i>Maestro</small>
                  
 
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">



                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive resize-margin-top">
                          
                                
                          <table id="table_ubigeo"  class="table tbl_out_margin table-striped" >
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Código</th>
                                  <th>Departamento</th>    
                                  <th>Acción</th>                          
                                </tr>
                              </thead>
                            <tbody></tbody>
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

@include('ubigeo.modals.create')
@endsection

@section('js')   
<!-- Js de la hoja-->
<script src="{{asset('js/jsApp/ubigeo.js')}}"></script>
@endsection
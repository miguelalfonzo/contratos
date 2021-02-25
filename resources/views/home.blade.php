@extends('layout')

@section('css')

<link href="{{asset('css/principal.css')}}" rel="stylesheet">

<style type="text/css">

  /*agregar 24/02/21*/
  .indicador{
    font-size: 15px !important;     font-weight: bold;
  }

/*  fin 24/02/21*/
</style>

@endsection

@section('content')
<!-- page content -->
       <div class="right_col" role="main">
          
          @inject('alertas', 'App\Alerta')
  
          <?php
          
            //fianza
            $indicadores_fianza = $alertas->get_indicadores_fianzas();
          
            $count_fianza_vence_hoy  = $indicadores_fianza[0]['cantidad'];

            $count_fianza_vencidas   = $indicadores_fianza[1]['cantidad'];

            $count_fianza_por_vencer = $indicadores_fianza[2]['cantidad'];

            //obra
            $indicadores_obra = $alertas->get_indicadores_obra();

            $count_obras = $indicadores_obra['cantidad'];

            $totalizado_obras = $indicadores_obra['totalizado'];


            //garantias
            $indicadores_garantia = $alertas->get_indicadores_garantias();
          
            $count_garantia_vence_hoy  = $indicadores_garantia[0]['cantidad'];

            $count_garantia_vencidas   = $indicadores_garantia[1]['cantidad'];

            $count_garantia_por_vencer = $indicadores_garantia[2]['cantidad'];

            //cumpleanos

            $indicadores_cumpleanos = $alertas->get_indicadores_cumpleanos();

           
            $count_cumpleanos_hoy = $indicadores_cumpleanos[0]['cantidad'];

            $count_proximos_cumpleanos = $indicadores_cumpleanos[1]['cantidad'];

          ?>

          

          <div class="">
            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph">
                
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                      {{Session::get('success')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    @endif


                    
                <div class="row x_title">
                  <div class="col-sm-6 col-12 ">
                     <div class="">
                        <h3><span>Cuadro de control</span></h3> 
                      </div> 
                  </div>

                <!-- agregar 24/02/21 -->

                  <div class="row col-12">
                     <div class=" row mx-0 col-12 col-sm-6 col-md-4 tile_count my-md-0 my-xl-3">
                       <label class=" col col-12"  style="text-align: center; font-weight: bold">CARTAS FIANZAS</label>
                       <div class="col-3 col-md-12 col-xl-3 row mx-0">
                        <!--  <i class="fa fa-line-chart" style="font-size: 30px"></i> --> 
                         <i class="fa fa-envelope-o m-auto " style="font-size: 30px"></i> 
                       </div>

                       <div class=" col-9 col-md-12 col-xl-9  mb-0 pb-0" style="text-align: right;">
                         <a href=""  data-type='vence-hoy'class="alerta-cartas-fianzas d-block">Fianzas Que Vence Hoy&nbsp;<span class="indicador">{{$count_fianza_vence_hoy}}</span></a>
                         <a href=""  data-type='vencidas' class="alerta-cartas-fianzas d-block">Fianzas Vencidas&nbsp;<span  class="indicador">{{$count_fianza_vencidas}}</span></a>
                         <a href="" data-type='por-vencer' class="alerta-cartas-fianzas d-block">Fianzas Por Vencer&nbsp;<span  class="indicador">{{$count_fianza_por_vencer}}</span></a>

                       </div>
                     </div>

                     <div class=" row mx-0 col-12 col-sm-6 col-md-4 tile_count my-md-0 my-xl-3  border border-dark border-top-0 border-bottom-0">
                       <label class=" col col-12"  style="text-align: center; font-weight: bold">GARANTIAS</label>
                       <div class="col-3 col-md-12 col-xl-3 row mx-0">
                        <!--  <i class="fa fa-line-chart" style="font-size: 30px"></i> --> 
                         <i class="fa fa-shield m-auto" style="font-size: 30px"></i> 
                       </div>

                       <div class=" col-9 col-md-12 col-xl-9  mb-0 pb-0" style="text-align: right;">
                         <a  href="" data-type='vence-hoy' class="alerta-garantias d-block">Garantias Que Vence Hoy&nbsp;<span class="indicador">{{$count_garantia_vence_hoy}}</span></a>
                         <a  href="" data-type='vencidas' class="alerta-garantias d-block">Garantias Vencidas&nbsp;<span  class="indicador">{{$count_garantia_vencidas}}</span></a>
                         <a  href="" data-type='por-vencer' class="alerta-garantias d-block">Garantias Por Vencer&nbsp;<span  class="indicador">{{$count_garantia_por_vencer}}</span></a>

                       </div>
                     </div>

                     <div class="row mx-0 col-12 col-sm-6 col-md-4 tile_count  my-md-0 my-xl-3">
                       <label class="col col-12"  style="text-align: center; font-weight: bold">OBRAS</label>
                       <div class=" col-3 col-md-12 col-xl-3 row mx-0">
                         <i class="fa fa-bar-chart m-auto" style="font-size: 30px"></i>
                       </div>

                       <div class=" col-9 col-md-12 col-xl-9  mb-0 pb-0" style="text-align: right;">
                         <a href="{{url('/obras')}}" class="d-block ">Obras En Trámite&nbsp;<span  class="indicador " style="font-size: 30px !important">{{$count_obras}}</span></a>
                         <p  class="d-block  ">Por S/.&nbsp;<span  class="indicador">{{$totalizado_obras}}</span></p>
                       </div>
                     </div>


                     <!-- cumpleanos -->

                     <div class=" row mx-0 col-12 col-sm-6 col-md-4 tile_count my-md-0 my-xl-3  border-right border-dark border-top-0 border-bottom-0">
                       <label class=" col col-12"  style="text-align: center; font-weight: bold">RECORDATORIOS</label>
                       <div class="col-3 col-md-12 col-xl-3 row mx-0">
                        <!--  <i class="fa fa-line-chart" style="font-size: 30px"></i> --> 
                         <i class="fa fa-gift m-auto" style="font-size: 30px"></i> 
                       </div>

                       <div class=" col-9 col-md-12 col-xl-9  mb-0 pb-0" style="text-align: right;">
                         <a  href="" data-type='cumpleanos-hoy' class="alerta-cumpleanos d-block">Cumpleaños de Hoy&nbsp;<span class="indicador">{{$count_cumpleanos_hoy}}</span></a>
                         <a  href="" data-type='proximos-cumpleanos' class="alerta-cumpleanos d-block">Próximos Cumpleaños&nbsp;<span  class="indicador">{{$count_proximos_cumpleanos}}</span></a>
                         <a  href="" data-type='todos' class="alerta-cumpleanos d-block">Todos&nbsp;</a>

                       </div>
                     </div>
                  </div>

                  

                   <!-- top tiles -->
                  <div class="row col-12 p-0" style="" >
                    <div class="tile_count col-12 p-0 m-0 pt-1" id="graficoSuperior">                   

                    </div>
                  </div>
                  <!-- /top tiles -->
                  
                </div>

                <!-- <div class="col-md-9 col-sm-9 ">
                  <div id="chart_plot_01" class="demo-placeholder"></div>
                 <div class="col-12 row justify-content-center p-0 m-0">
                 <span><i class="fa fa-square" style="color: rgba(180, 241, 222, 0.9)"></i> Contratos &nbsp</span>
                 <span><i class="fa fa-square" style="color: rgba(162, 191, 204, 0.9)"></i> Consultas &nbsp</span>
                 </div>

                 <div  > <canvas id="line-chart" width="400" height="400" ></canvas> </div>
                </div> -->

                
                <!-- <div class="col-md-3 col-sm-3  bg-white">


                  <div class="x_title">
                    {{-- <h2>Top Campaign Performance</h2> --}}
                    <h2>Top Campaign Contratos</h2>
                    <div class="clearfix"></div>
                  </div> 

                 

                  <div class="col-md-12 col-sm-12 " id="grafico_barra">
                   

                   <div>
                      <p>Bill boards</p>
                      <div class="">
                        <div class="progress progress_sm" style="width: 76%;">
                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                        </div>
                      </div>
                    </div> 

 
                  </div>
                </div> -->

               <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />

        </div>
        <!-- /page content -->

@include('alertas.alertas_fianzas')
@include('alertas.alertas_garantias')
@include('alertas.alertas_cumpleanos')
@endsection

@section('js')

<script type="text/javascript" src="{{asset('js/jsApp/alertas.js')}}"></script>
    
@endsection

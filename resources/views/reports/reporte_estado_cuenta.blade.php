<html>
<head>
  <title>Reporte Estado Cuenta</title>
  <style>
    body{
      font-family: sans-serif;
    }
    @page {
      margin: 110px 50px 70px 50px;
    }
    header { position: fixed;   
      left: 0px;
      top: -110px;
      right: 0px;
      height: 250px; 
      
      /*background-color: #ddd;*/
    }
   
    footer {
      position: fixed;
      left: 0px;
      bottom: -40px;
      right: 0px;
      height: 40px;
      border-bottom: 2px solid #ddd;
    }
    footer .page:after {
      content: counter(page);
    }
    footer table {
      width: 100%;
    }
    footer p {
      text-align: right;
      font-size: 10px;
      margin: 2px;
    }
    footer .izq {
      text-align: left;
      font-size: 12px;
    }

    tfoot tr td{
      text-align: right;
      padding-left: 10px;
    }
    .color-porcentaje{

      color:black;
    }
    .page{

        font-size: 12px;
    }
    .customers {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      font-size: 8px;
      width: 100%;
      padding-top: 0px;
    }

    .customers td{
       
      padding: 2px;
      font-size: 8px;
      
    } 

    #content{
     padding-bottom: 0px;
    }

    #customers th {
  padding-top: 6px;
  padding-bottom: 6px;
  text-align: center;
  background-color: #B6BBB7;
  color: black;

}


  </style>
</head>
<body>
  <header >
          <table style="width: 100%;font-size: 14px;padding-top: 6px;padding-bottom: 6px;font-weight: normal;">
                    <tr>
                        <th style="width:30%">
                            <img src="{{ asset('img/transcapital.jpg') }}" alt="..." class="" width="140" height="30"></span>
                        </th>
                        <th style="width:70%;text-align: center;">
                            <h4 style="text-decoration: underline;color: blue">Estado de Cuenta</h4>
                            <h5 style="margin-top: -5px">{{$identificacion}} - {{$empresa}}</h5>
                        
                        </th>
                       
                       
                    </tr>


                    <tr><td colspan="2"><small>Fecha Impresión : {{date('d/m/Y')}}</small></td></tr>                                                                     
            </table>


          
          
  </header>
  <footer>
    <table>
      
      <tr>
        <td>
            <p class="izq">
             Estado de Cuenta - {{$empresa}}
            </p>
        </td>
        <td>
          <p class="page">
            Página
          </p>
        </td>
      </tr>
    </table>
  </footer>


      <div id="content">

        
        <!-- <table id="customers" style="width: 100%;font-size: 9px;margin-top: 10px">
                <thead >
                   
                    <tr>
                        <th>Financiera</th>
                        <th>Obra</th>
                        <th>Cliente/Consorcio</th>
                        <th>Carta</th>
                        <th>Número</th>
                        <th>Vence</th>
                        <th>Original</th>
                        <th>Actual</th>
                        
                    </tr>
                </thead>
                <tbody>

                    
                    @foreach($cartas as $list)

                       
                       
                        <tr>
                        <td>{{$list->fullNameFinanciera}}</td>
                        <td>{{$list->Descripcion}}</td>
                        <td>{{$list->fullNameCliente}}</td>
                        <td>{{$list->DescripcionTipoCarta}}</td>
                        <td>{{$list->CodigoCarta}}</td>
                        <td>{{$list->FechaVence}}</td>
                        <td>{{number_format($list->MontoOriginal, 2, '.', ',')}}</td>
                        <td>{{number_format($list->MontoActual, 2, '.', ',')}}</td>
                        </tr>

                       

                    @endforeach
                </tbody>
                
                </table> -->
          

         
          


        <table id="customers" style="width: 100%;font-size: 9.5px;margin-top: 10px">
                <thead >
                   
                    <tr>
                        <th>Cliente/Consorcio</th>
                        <th>Tipo Fianza</th>
                        <th>Número</th>
                        <th>Vence</th>
                        <th>Original</th>
                        <th>Actual</th>
                        
                    </tr>
                </thead>
                <tbody>

                    <?php

                      $tot_original = 0;

                      $tot_actual = 0;

                    ?>

                    
                    

                    @foreach($final as $list)

                        <?php

                          $tot_finan_original=0;
                          $tot_finan_actual =0;

                      ?>

                       
                        <tr><td colspan="6"></td></tr>
                        <tr style="color:red">

                          <td>{{$list['financiera']}}</td>
                          <td></td>
                          <td></td> 
                          <td></td>
                          <td ><!-- {{$list['totalizado_financieras_original']}} --></td> 
                          <td ><!-- {{$list['totalizado_financieras_actual']}} --></td>
                        
                        </tr>

                        <?php

                          //$tot_original=$tot_original+$list['totalizado_financieras_original'];
                          //$tot_actual=$tot_actual+$list['totalizado_financieras_actual'];

                        ?>


                        <tr><td colspan="6"></td></tr>
                        @foreach($list['detalle'] as $key)

                          <tr style="color:blue">

                            <td>{{$key['obra']}}</td>
                            <td></td>
                            <td></td> 
                            <td></td> 
                            <td> <!-- {{$key['suma_original']}} --></td>
                            <td> <!-- {{$key['suma_actual']}} --></td>
                        
                          </tr>


                          <?php
                              $sub_suma_cartas_original=0;
                              $sub_suma_cartas_actual =0;
                          ?>


                          @foreach($key['sub_detalle'] as $last)
                              <?php

                                $original_calculado=round($last->MontoOriginal*$array_porc[$last->IdCliente]/100,2);

                                $actual_calculado=round($last->MontoActual*$array_porc[$last->IdCliente]/100,2);
                              ?>
                              <tr style="color:green">

                                


                                <td>{{$last->fullNameCliente}} </td>
                                <td>{{$last->DescripcionTipoCarta}} </td>
                                <td>{{$last->CodigoCarta}} </td>
                                <td>{{$last->FechaVence}} </td>
                                <!-- <td>{{$last->MontoOriginal}} <span class="color-porcentaje"> {{$array_porc[$last->IdCliente]}}%</span></td>
                                <td>{{$last->MontoActual}} <span class="color-porcentaje">{{$array_porc[$last->IdCliente]}}%</span> </td> -->
                                <td>{{number_format($original_calculado, 2, '.', ',')}}
                                  <small class="color-porcentaje"> {{$array_porc[$last->IdCliente]}}%
                                  </small>
                                </td>
                                <td>{{number_format($actual_calculado, 2, '.', ',')}} 
                                  <small class="color-porcentaje">{{$array_porc[$last->IdCliente]}}%
                                  </small> 
                                </td>
                             </tr>

                             <?php
                              $sub_suma_cartas_original=$sub_suma_cartas_original+ $original_calculado;

                              $sub_suma_cartas_actual=$sub_suma_cartas_actual+ $actual_calculado;

                              //totalizado x financiera

                                 $tot_finan_original=$tot_finan_original+$original_calculado;
                                 $tot_finan_actual = $tot_finan_actual+ $actual_calculado;

                              //totalizado final de todo

                                 $tot_original=$tot_original+$original_calculado;
                                $tot_actual=$tot_actual+$actual_calculado;

                             ?>

                          @endforeach


                        <tr style="color:blue">
                          <td colspan="1"></td>
                          <td colspan="3">{{$key['obra']}}</td>
                          <td>{{number_format($sub_suma_cartas_original, 2, '.', ',')}}</td>
                          <td>{{number_format($sub_suma_cartas_actual, 2, '.', ',')}}</td>
                        </tr>
                        @endforeach
                       

                      <tr style="color:red">
                        

                       <td colspan="1"></td>
                       <td colspan="3">{{$list['financiera']}}</td>
                       <td>{{number_format($tot_finan_original, 2, '.', ',')}}</td>
                       <td>{{number_format($tot_finan_actual, 2, '.', ',')}}</td>

                    </tr>

                    @endforeach
                    
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    <tr><td colspan="6"></td></tr>
                    
                    <tr>
                      <td colspan="4"></td> 


                        <td><strong>{{number_format($tot_original, 2, '.', ',')}}</strong></td>
                        <td><strong>{{number_format($tot_actual, 2, '.', ',')}}</strong></td>
                    </tr>
                </tbody>
                
                </table>
         

      </div>
          <!-------------------------------------------------------------  fin primer foreach ------------------------------------>
           
</html>
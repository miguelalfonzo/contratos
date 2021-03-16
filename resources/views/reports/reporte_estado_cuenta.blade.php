<html>
<head>
  <title>Reporte Estado Cuenta</title>
  <style>
    body{
      font-family: sans-serif;
    }
    @page {
      margin: 80px 50px 70px 50px;
    }
    header { position: fixed;   
      left: 0px;
      top: -80px;
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

        
        <table id="customers" style="width: 100%;font-size: 9px;margin-top: 10px">
                <thead >
                   
                    <tr>
                        <th>Financiera</th>
                        <th>Obra</th>
                        <th>Cliente</th>
                        <th>Carta</th>
                        <th>Número</th>
                        <th>Vence</th>
                        <th>Original</th>
                        <th>Actual</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($obras as $list)

                       
                       
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
                
                </table>
        
          

         

      </div>
          <!-------------------------------------------------------------  fin primer foreach ------------------------------------>
           
</html>
<html>
<head>
    <title>Historial de Obra </title>
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
      text-align: center;
    }
    header h1{
      margin: 10px 0;
    }
    header h2{
      margin: 0 0 10px 0;
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
    }
    footer .izq {
      text-align: left;
      font-size: 12px;
    }
    
    .page{

        font-size: 12px;
    }
    #customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers th {
  border: 1px solid #ddd;
  padding: 6px;
  font-size: 12px;

}
#customers td{
     border: 1px solid #ddd;
  padding: 4px;
     font-size: 11px;
     text-align: center;
    
}
#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 6px;
  padding-bottom: 6px;
  text-align: center;
  background-color: #B6BBB7;
  color: black;

}

#datos td{
    padding-right: 10px;
    text-align: right;
}

#totales td{
    padding-right: 10px;
    text-align: right;
}

.padding-rows{
  padding: 5px;
}

  </style>

<body>
  <header>
    <table style="width: 100%;font-size: 14px;padding-top: 6px;padding-bottom: 6px;font-weight: normal;">
                    <tr>
                        <th style="width:30%">
                            <img src="{{ asset('img/transcapital.jpg') }}" alt="..." class="" width="140" height="30"></span>
                        </th>
                        <th style="width:70%;text-align: center;">
                            <h4 style="text-decoration: underline;">Historial de Obra</h4>
                            <h5 style="margin-top: -5px">"{{$cliente_cabecera}}"</h5>
                        
                        </th>
                       
                       
                    </tr>                                                                       
            </table>

             

            

  </header>

  <footer>
    <table>
      <tr>
        <td>
            <p class="izq">
              Historial de Obra - {{$cliente_cabecera}}
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
    
                    
            
        
            @foreach($array_final as $list)
                
                <h6>Financiera : <span style="color:red;">{{$list['Financiera']}}</span></h6>
                <h6 style="margin-top: -15px">Obra : <span style="color:blue;">{{strtoupper($list['Obra'])}}</span></h6>
                
                <h6 style="margin-top: -15px">Impresión : <span style="">{{date('d/m/Y')}}</span></h6>

                <table id="customers" style="width: 100%">
                <thead>
                    <tr><th colspan="8">CARTAS FIANZAS</th></tr>
                    <tr>
                        <th>Tipo Fianza</th>
                        <th>Número</th>
                        <th>Inicio</th>
                        <th>Vence</th>
                        <th>Renovada</th>
                        <th>Monto Original</th>
                        <th>Monto Actual</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list['cartas'] as $list2)

                        <tr>
                        <td>{{$list2['tipo']}}</td>
                        <td>{{$list2['codigo_carta']}}</td>
                        <td>{{$list2['inicio']}}</td>
                        <td>{{$list2['vence']}}</td>
                        <td>{{$list2['renovada']}}</td>
                        <td>{{number_format($list2['monto_original'], 2, '.', ',')}}</td>
                        <td>{{number_format($list2['monto_actual'], 2, '.', ',')}}</td>
                        <td>{{$list2['estado']}}</td>
                        </tr>


                    @endforeach
                </tbody>
                
                </table>

            @endforeach   

            <table id="customers" style="width: 100%;margin-top: 10px">
                <thead>
                    <tr><th colspan="9">GARANTIAS</th></tr>
                    <tr>
                        <th>Carta</th>
                        <th>Garantía</th>
                        <th>Número</th>
                        <th>Emisión</th>
                        <th>Moneda</th>
                        <th>Monto</th>
                        <th>Cobrado</th>
                        <th>Disponible</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agrupa_cartas_garantias as $list3)

                        <tr>
                        <td>{{$list3['carta']}}</td>
                        <td>{{$list3['garantia']}}</td>
                        <td>{{$list3['documento']}}</td>
                        <td>{{$list3['emision']}}</td>
                        <td>{{$list3['moneda']}}</td>
                        <td>{{number_format($list3['monto'], 2, '.', ',')}}</td>
                        <td>{{$list3['cobro']}}</td>
                        <td>{{number_format($list3['disponible'], 2, '.', ',')}}</td>
                        <td>{{$list3['estado']}}</td>
                        </tr>


                    @endforeach
                </tbody>
              </table>
                
                           
                
  </div>
</body>
</html>

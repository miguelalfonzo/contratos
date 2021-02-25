<html>
<head>
  <title>Reporte Representante</title>
  <style>
    body{
      font-family: sans-serif;
    }
    @page {
      margin: 75px 30px 70px 30px;
    }
    header { position: fixed;   
      left: 0px;
      top: -50px;
      right: 0px;
      height: 100px; 
      
      /*background-color: #ddd;*/
    }
   
    footer {
      position: fixed;
      left: 0px;
      bottom: -10px;
      right: 0px;
      height: 10px;
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
     
      width: 100%;
      padding-top: 0px;
    }

    .customers td{
       
      padding: 2px;
      font-size: 10px;
      
    } 

    #content{
     padding-bottom: 0px;
    }

  </style>
</head>
<body>
  <header >
          <table style="width: 100%;font-size: 15px;font-weight: bold;">
                    <tr >
                        <th style=";width:20%">
                            <img src="{{ asset('img/transcapital.jpg') }}" alt="..." class="" width="140" height="30"></span>
                        </th>
                        <th  style="width:60%;text-align: center;">
                           Reporte de Fecha de Cumpleaños
                        
                        </th> 
                        <th style="width:20%; text-align: left;"> Fecha: {{date('d').'-'.date('m'). '-'.date('Y')}}</th>   
                    </tr>                                                                     
          </table>


          <!-- <div style="font-size: 13px"><p>Empresa:&nbsp;<span>20254789651 - empresa constructora</span></p> </div> 
        
          <table style="width: 100%" class="m-0 p-0">
           
                    <tr class="" style="font-size: 13px !important;width: 100%;">
                        <th style="width: 40%;border:solid 1px red">Representantes Legales</th>
                        <th style="width: 30%;border:solid 1px red">Fecha de Cumpleaños</th>
                        <th style="width: 30%;border:solid 1px red">Dias Restantes</th>
                    </tr>
               
          </table> --> 
          
  </header>
  <footer>
    <table>
      <tr>
        <td colspan="2">
           <p class="izq">
             Atentamente
            </p>
        </td>
      </tr>
      <tr>
        <td>
            <p class="izq">
             Sistema de mensajería TRANSCAPITAL
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

        <div style="font-size: 13px; font-weight: bold; color: #2A5D7F"><p>Empresa:&nbsp;<span>20254789651 - empresa constructora</span></p> </div> 
        
          <table style="font-size: 13px; width: 100%" class="m-0 p-0">

            <thead>
              <tr>
                  <th style="width: 40%;">Representantes Legales</th>
                  <th style="width: 30%;">Fecha de Cumpleaños</th>
                  <th style="width: 30%;">Dias Restantes</th>
              </tr>
            </thead>

            <tbody>
              <tr >
                <td width="40%">maxs rojas poma</td>
                <td width="30%" style="text-align: center;">21/09 </td>
                <td width="30%" style="text-align: center;">152</td>
              </tr>
            </tbody>
                
           
          </table>

          <hr>

          <div style="font-size: 13px; font-weight: bold;  color: #2A5D7F"><p>Empresa:&nbsp;<span>20254789651 - empresa constructora</span></p> </div> 
        
          <table style="font-size: 13px; width: 100%" class="m-0 p-0">

            <thead>
              <tr>
                  <th style="width: 40%;">Representantes Legales</th>
                  <th style="width: 30%;">Fecha de Cumpleaños</th>
                  <th style="width: 30%;">Dias Restantes</th>
              </tr>
            </thead>

            <tbody>
              <tr >
                <td width="40%">maxs rojas poma</td>
                <td width="30%" style="text-align: center;">21/09 </td>
                <td width="30%" style="text-align: center;">152</td>
              </tr>
            </tbody>
                
           
          </table>

          <hr>

          <div style="font-size: 13px; font-weight: bold; color: #2A5D7F"><p>Empresa:&nbsp;<span>20254789651 - empresa constructora</span></p> </div> 
        
          <table style="font-size: 13px; width: 100%; border-bottom: solid 1px black" class="m-0 p-0">

            <thead>
              <tr>
                  <th style="width: 40%;">Representantes Legales</th>
                  <th style="width: 30%;">Fecha de Cumpleaños</th>
                  <th style="width: 30%;">Dias Restantes</th>
              </tr>
            </thead>

            <tbody>
              <tr >
                <td width="40%">maxs rojas poma</td>
                <td width="30%" style="text-align: center;">21/09 </td>
                <td width="30%" style="text-align: center;">152</td>
              </tr>
            </tbody>
                
           
          </table>

         

      </div>
          <!-------------------------------------------------------------  fin primer foreach ------------------------------------>
           
</html>

<div id="modal-alertas-cumpleanos"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  
                    
                   
                  <div class="modal-header">

                          <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-birthday-cake icon-right"></i><span id="span_alerta_cumpleanos_label"></span></span></h6>
                          
                          <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">

                      <div class="col-md-12 col-sm-12">
                      <div class="form-group row mx-0">
                        
                        

                      <div class="col-lg-6 col-9">

                        <input type="text" id="buscador_alertas_cumpleanos"  class="form-control resize-input btn-round" placeholder="Buscar..." autocomplete="off">

                      </div>  


                      <div class="col-lg-6 col-3">

                        <button id="btn_exportar_todos_cumpleanos"onclick="exportar_todos_cumpleanos()" style='display: none'class="btn btn-success btn-sm resize-button"><i class="fa fa-file-excel-o mr-2"  ></i>Exportar</button>

                      </div>                    

                      </div>                  
      
                    <div class="card-box table-responsive" >

                            
                  <table id="tabla-alertas-cumpleanos" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                
                    <thead>
                    <tr>
                     
                      <th>Empresa</th>
                      <th>Representante</th>
                      <th>Teléfono</th>
                      <th>Email</th>
                      <th>Cumpleaños</th>  
                      
                                                                  
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


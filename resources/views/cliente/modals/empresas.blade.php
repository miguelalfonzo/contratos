
<div id="modal-ver-empresas"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  
                    
                   
                  <div class="modal-header">

                          <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Empresas - <span id="lbl_cabecera_empresas_asoc"></span></span></h6>
                          
                          <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">

                      
                      

                      <div class="col-md-12 col-sm-12">
                      <div class="form-group row ">
                        
                        <input type="hidden" id="hidden_consorcio_id_modal" value="0" 
                        >

                        <input type="hidden" id="hidden_cliente_id_modal" 
                        >


                        <label class="control-label col-lg-2 col-md-2 margin-top-10">Agregar Empresa</label>
                        <div class="col-lg-4 col-md-10 margin-top-10">

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">+</div>
                            </div>
                           <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Empresa" id="empresa_nombre" name="empresa_nombre"  autocomplete="off" maxlength="50" value="">


                           <div id="empresas_agregar_consorcio" class="list-autocompletar">
                          </div>

                        </div>
                      


                         
                        
                        
                       
                      </div>

                      <div class="col-lg-6 col-md-12 margin-top-10">

                        <input type="text" placeholder="Buscar..." class="form-control-sm form-control" id="search_table_empresas" >

                      </div>
                      

                      </div>

                      
      
                      

                      <div class="card-box table-responsive" >

                            
                  <table id="table-cliente-empresas" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                
                    <thead>
                    <tr>
                      <th style="display: none">IdCliente</th>
                      <th>N° Documento</th>
                      <th>Razon Social</th>  
                      <th>%</th>                   
                      <th><i class="fa fa-edit"></i></th>                                   
                   </tr>
                  </thead>
                  
                  <tbody></tbody>
                  </table>
                  </div>


                      </div>
        

                    </div>
                    </div>

                          <div class="modal-footer">
                            <button type="button" class="btn btn-success resize-button btn-sm" id="btn_salvar_modal_empresas"style="display: none"><i class="fa fa-save mr-1" ></i>Grabar</button>
                          </div>

                    
                   




                    

              </div>

        </div>
</div>


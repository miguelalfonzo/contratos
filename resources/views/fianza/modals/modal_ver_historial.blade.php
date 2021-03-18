
<style type="text/css">
  .content {
    background: white !important;
  }
</style>
<div id="modal_ver_historial_carta"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                   
                  <div class="modal-header">

                          <div class="col-sm-9">
                            
                            <h3 class="modal-title " ><span class="badge badge-success"><i class="fa fa-eye icon-right"></i>Ver Historial Carta Fianza</span></h3>

                          </div>
                          
                          <div class="col-sm-3">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                                                   

                          </div>
                          
                    </div>
                    <div class="modal-body">

                      <div class="content">
           

            

            <div id="wizard" >
                <h4>Datos Carta Fianza</h4>
                <section style="padding: 2px  !important;" >
                   
                   <div class="row">

                     <!----------------------  mdr = modal_datos_renovacion ------------------->
                      <div class="col-xl-12  col-md-12 " style="margin-left: 20px">
                        <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                            <div class="form-group row resize-margin-top-12 mb-0 ">

                              <input type="hidden" id="hist_idcliente" name="hist_idcliente">
                               <label class="control-label col-md-2 col-sm-2 margin-top-10">Cliente</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">
                                
                                 

                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>

                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_cliente" name="hist_cliente" autocomplete="off"  readonly>
                                  </div>

          
                                </div>
                                
                                
                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Beneficiario</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm" placeholder="" id="hist_beneficiario" name="hist_beneficiario" autocomplete="off" maxlength="100" readonly>
                                  </div>


                                </div>

                              <!--   ------------- -->

                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Entidad Financiera</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_financiera" name="hist_financiera"  autocomplete="off" maxlength="100" readonly>
                                  </div>



                                </div>
                                <!--   ------------- -->

                                <!--   ------------- -->

                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Files</label>

                                <div class="col-md-2 col-sm-2 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    
                                    <a class="btn btn-dark btn-sm resize-button" href="" id="hist_avance_obra" onclick="ver_file_historial('A');return false"data-file="">Avance Obra</a>

                                  </div>



                                </div>

                                <div class="col-md-2 col-sm-2 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    
                                    <a class="btn btn-dark btn-sm resize-button" href="" id="hist_doc_electronico" onclick="ver_file_historial('D');return false" data-file="">Documento E.</a>
                                  </div>



                                </div>
                                <!--   ------------- -->
                                
                              
                          <!--   --------------  -->
                            </div>

                            </div>
                          </div>
                          
                        </div>


                    <!-- ---------------parecen en tabla------------ -->

                      <div class="col-xl-12  col-md-12 " style="margin-left: 20px">
                          <div class="x_panel m-0">
                          <div class="x_content pb-0">
                              
                               
                              <div class="form-group row resize-margin-top-12 mb-0">

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° Interno(Cod obra)</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_num_interno" name="hist_num_interno"  autocomplete="off" maxlength="20" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Tipo Fianza</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_tipo_fianza" name="hist_tipo_fianza"  autocomplete="off" maxlength="20" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 ">Número Carta</label>
                                  <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_numero_carta" name="hist_numero_carta"  autocomplete="off" maxlength="100" value="" readonly="">
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 ">N° Solicitud</label>
                                  <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_solicitud" name="hist_solicitud"  autocomplete="off" maxlength="100" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 ">Moneda</label>
                                  <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-money"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_moneda" name="hist_moneda"  autocomplete="off" maxlength="100" readonly>
                                    </div>

                                  </div>

                                 
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 ">Monto</label>
                                  <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-money"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_monto" name="hist_monto"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>

                                   <!----------------->
                                  
                                  <label class="control-label col-xl-3 col-sm-2 ">Estado</label>
                                  <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-cog"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_estado" name="hist_estado"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>

                                  
                                
                                <!--   ------------- -->

                                 <label class="control-label col-xl-3 col-sm-2 ">Fecha Creación</label>
                                <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_fe_creacion" name="hist_fe_creacion"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 ">Fecha Inicio</label>
                                <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_fe_inicio" name="hist_fe_inicio"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 ">Dias</label>
                                <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_dias" name="hist_dias"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 ">Fecha Vencimiento</label>
                                <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-calendar"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_fe_vencimiento" name="hist_fe_vencimiento"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 ">N° Renovación</label>
                                <div class="col-xl-3 col-sm-4 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_n_renovacion" name="hist_n_renovacion"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>

                                  

                            <!----------------->

                            <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 ">Observación</label>
                                <div class="col-xl-9 col-sm-10 ">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-edit"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="hist_observacion" name="hist_observacion"  autocomplete="off"  value="" readonly="">
                                    </div>

                                  </div>

                                  

                            <!----------------->
                              </div>

                            </div>
                          </div>
                          
                        </div>

                        

                    </div>

                </section>



                <h4>Cartas Fianzas Relacionadas</h4>
                <section>
                    
                    
                    <div class="card-box table-responsive ">

                    <table id="table-historial-frel" class="table   jambo_table letra-size-tablas table-striped" style="width: 100%"> 

                                <thead>
                                   <tr>
                          <th>CF Anterior</th> 
                          <th>Nro Carta Fza</th>
                          <th>Tipo Carta Fza</th>  
                          <th>Moneda</th> 
                          <th>Monto</th> 
                          
                          <th>Inicio</th> 
                          <th>Vence</th> 
                          <th>Renovación</th>  
                          <th>Estado</th>    
                       </tr>
                              </thead>
                                <tbody>
                                  <tr>
                                     <th>Nro Carta Fza</th>
                          <th>Tipo Carta Fza</th>  
                          <th>Moneda</th> 
                          <th>Monto</th> 
                          <th>CF Anterior</th> 
                          <th>Inicio</th> 
                          <th>Vence</th> 
                          <th>Renovación</th>  
                          <th>Estado</th>   

                                  </tr>
                                                
                                </tbody>
                                
                            </table>

                          </div>

                </section>

                <h4>Garantias Relacionadas</h4>
                <section>

                  <div class="card-box table-responsive ">
                    <table id="table-historial-grel" class="table   jambo_table letra-size-tablas table-striped" style="width: 100%"> 

                                <thead>
                                  <tr>
                                    <th>Fecha</th>
                                    <th>Tipo de Garantía</th>
                                    <th>Nro Documento</th>  
                                    <th>Monto Fianza</th> 
                                    <th>(%)</th> 
                                    <th>Monto</th> 
                                    <th>Emisión</th> 
                                    <th>Vence</th> 
                                    <th>Cobro</th>
                                    <th>Requerido</th>                                   
                                    <th>Liberable</th> <!-- antes disponible -->
                                    <th>Estado</th>    
                                </tr>
                              </thead>
                                <tbody>
                                  
                                                
                                </tbody>
                                
                            </table>
                          </div>
                </section>



                
            </div>
        </div>

                            
                    </div>



              </div>

        </div>
</div>


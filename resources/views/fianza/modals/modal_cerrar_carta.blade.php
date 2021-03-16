
<div id="modal_cerrar_carta"class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
              <div class="modal-content">
                   
                  <div class="modal-header">

                          <div class="col-sm-9">
                            
                            <h3 class="modal-title text-success" ><span class="badge badge-danger"><i class="fa fa-minus-square icon-right"></i>Cerrar Carta Fianza</span></h3>

                          </div>
                          
                          <div class="col-sm-3">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                                                   

                          </div>
                          
                    </div>
                    <div class="modal-body">

                      <div class="row">
  
                          <div class="col-12 ">
        
                                <form method="POST" action="" id="cerrar_fianza_form">

                                  <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                                      <div class="form-group row resize-margin-top-12 mb-0 ">
                                          <input type="hidden" id="cerrar_cf_idcarta" name="cerrar_cf_idcarta">
                                          
                                          <input type="hidden" id="cerrar_estado_carta_fianza" name="cerrar_estado_carta_fianza" value="CER">

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Cliente</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                          </div>

                                  


                                            <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"   id="cerrar_cf_cliente" name="cerrar_cf_cliente" value="" readonly>
                                          </div>

          
                                          </div>

                                          <!--  -->

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Contratante</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                          </div>

                                  


                                            <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"   id="cerrar_cf_contratante" name="cerrar_cf_contratante" value="" readonly>
                                          </div>

          
                                          </div>

                                          <!--  -->

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Financiera</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                          </div>

                                  


                                            <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"   id="cerrar_cf_financiera" name="cerrar_cf_financiera" value="" readonly>
                                          </div>

          
                                          </div>

                                          <!--  -->

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Monto</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-money"></i></div>
                                          </div>

                                  


                                            <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"   id="cerrar_cf_moneda" name="cerrar_cf_moneda" value="" readonly>

                                            <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"   id="cerrar_cf_monto" name="cerrar_cf_monto" value="" readonly>
                                          </div>

          
                                          </div>

                                          <!--  -->



                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Comentario</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                                           <textarea class="form-control" id="cerrar_cf_comentario" name="cerrar_cf_comentario"></textarea>
          
                                          </div>

                                          <!--  -->


                                          <div class="col-md-12 col-sm-12 margin-top-10">
                                
                                            <button style="float:right;"class="btn btn-warning btn-sm resize-button" id="btn_cerrar_carta_fianza"><i class="fa fa-save mr-2"></i>Aceptar</button>
          
                                          </div>

                                      </div>

                                  </div>

                                </form>

                          </div>

                      </div>
                            
                    </div>



              </div>

        </div>
</div>


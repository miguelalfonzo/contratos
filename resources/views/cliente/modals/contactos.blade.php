<div id="modal-cliente-contactos"class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
              <div class="modal-content">

                  <div class="modal-header">
                          <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Contactos</span></h6>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                    </div>
                    <div class="modal-body">
                          
                        <div class="form-group row resize-margin-top-12 mt-1">

                          <input type="hidden" name="id_cliente_contacto" id="id_cliente_contacto">
                          
                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Contacto</label>
                      
                        <div class="col-md-8 col-sm-8 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-home"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Contacto" id="contacto_cliente" name="contacto_cliente" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="">
                          </div>
                        </div>
                        

                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Teléfono</label>

                        <div class="col-md-8 col-sm-8 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-phone"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Teléfono" id="telefono_cliente" name="telefono_cliente"  autocomplete="off" maxlength="11"  value="">
                          </div>
                        </div>

                          </div>

                          <div class="form-group row resize-margin-top-12">

  
                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Celular</label>
                        <div class="col-md-8 col-sm-8 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-mobile"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm numerosenteros"  placeholder="Celular" id="celular_cliente" name="celular_cliente" autocomplete="off" maxlength="11"  value="">
                          </div>
                        </div>
                        

                        <label class="control-label col-md-4 col-sm-4 margin-top-10">Email</label>

                        <div class="col-md-8 col-sm-8 ">
                          
                         <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">@</div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Email" id="email_cliente" name="email_cliente" autocomplete="off" maxlength="100"  value="">
                          </div>
                        </div>

                          </div>

                         
                          

                    </div>

                    <div class="modal-footer">
                      
                      <button id="btn_confirmar_contacto" class="btn btn-success btn-sm resize-button"><i class="fa fa-check mr-1"></i>Confirmar</button>


                    </div>

              </div>
        </div>
</div>
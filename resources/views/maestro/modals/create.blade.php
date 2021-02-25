<div id="modal-tabla-create" class="modal fade" tabindex="-1" aria-labelledby="ModalCreate"  role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-me" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      
                          <h5 class="modal-title ">
                            <span class="badge badge-dark"><i class="fa fa-th icon-right"></i></span> &nbsp<span class="badge badge-primary" id="lbl_accion">Crear Nueva Tabla</span></h5>
                            
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                          </button>
                    </div>


                    <div class="modal-body" style="padding-bottom: 0px">


                      <form class="form-group resize-margin-top">
                        
                         <div class="">
                          
                        <div class="form-group row margin-top-10">
                        <label class="control-label col-md-3 col-sm-3 ">Identificador</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" class="form-control resize-input resize-font disable-buton" name="id_tabla" id="id_tabla" value="0" disabled="true">
                        </div>
                        </div>

                       <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Descripción</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                          <input type="text" class="form-control resize-input resize-font" name="descripcion" id="descripcion" maxlength="200">
                        </div>
                        </div>

                         <div class="form-group row ">
                          <label class="control-label col-md-3 col-sm-3 ">Estado</label>
                            <div class="col-md-9 col-sm-9">
                            
                              <label>
                                <input class="js-switch" type="checkbox" id="switch_estado" name="switch_estado" checked>&nbsp;&nbsp;Activo
                              </label>  
                            </div>
                        </div>

                        

                         </div>
                       </form>                  
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success resize-button"id="salva_maestro"><i class="fa fa-edit mr-1"></i><span id="lbl_accion_maestro">Guardar</span></button>
                    </div>
             </div>
        </div>
</div>
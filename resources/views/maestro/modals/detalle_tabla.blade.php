 
<div id="modal-detalle-master" class="modal fade bs-example-modal-lg" tabindex="-1" aria-labelledby="ModalDetalleMaestro"  role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">

                          <h5 class="modal-title">
                            <span class="badge badge-dark"><i class="fa fa-th icon-right"></i></span>&nbsp<span class="badge badge-primary">Detalle - <span id="descripcion_tabla"></span></span>                          
                         </h5>

                         <div >
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                          </button>
                          
                          <button type="button" class=" btn btn-primary resize-button" id="btnNuevoDetalleTabla"><i class="fa fa-plus icon-right"></i>Nuevo</button>
                          </div>

                          
                    </div>
                    <div class="modal-body">

                        <div id="DivFormDetalleTabla" style="display: none">
                        <form class="form-group">
                        
                        <input type="hidden" name="id_tabla_detalle" id="id_tabla_detalle">
                        <div class="form-group row ">
                        <label class="control-label col-md-3 col-sm-3 ">Identificador</label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" class="form-control resize-input resize-font disable-buton" id="id_columna_detalle" name="id_columna_detalle" disabled="true">
                        </div>
                        </div>


                      <div class="form-group row resize-margin-top">
                        <label class="control-label col-md-3 col-sm-3">Valor <span id="valor_maximo" class="text-danger">(max 100 caracteres)</span></label>
                        <div class="col-md-9 col-sm-9 ">
                          
                          <input type="text" class="form-control resize-input resize-font" id="valor" maxlength="100" name="valor" autocomplete="off">
                        </div>
                        </div>

                      
                       <div class="form-group row resize-margin-top">
                        <label class="control-label col-md-3 col-sm-3">Descripción</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                          <input type="text" class="form-control resize-input resize-font" id="descripcion_detalle" maxlength="200" name="descripcion_detalle" autocomplete="off">
                        </div>
                        </div>

                        <div class="form-group row resize-margin-top">
                        <label class="control-label col-md-3 col-sm-3 ">V.Cadena</label>
                        <div class="col-md-9 col-sm-9 ">
                          
                          <input type="text" class="form-control resize-input resize-font" id="valor_cadena_detalle" name="valor_cadena_detalle" maxlength="200" autocomplete="off">
                        </div>
                        </div>


                         <div class="form-group row">
                          <label class="control-label col-md-3 col-sm-3 ">Estado</label>

                            <div class="col-sm-9 col-md-9">
                              <label>
                                <input class="js-switch" type="checkbox" id="switch_estado_detalle" name="switch_estado_detalle" checked>&nbsp;&nbsp;Activo
                              </label> 
                            </div>
                         </div>


                                             

                       </form>
                      

                        <div class="modal-footer pb-0">
                        

                        <button class="btn btn-warning resize-button" id="btnVolverDetalle"><i class="fa fa-reply mr-1"></i>Volver</button>

                        <button class="btn btn-success resize-button" id="btnSaveTablaDetalle"><i class="fa fa-edit mr-1"></i><span id="lbl_accion_detalle">Guardar</span></button>

                       
                                           
                        </div> 

                        </div>

                      <div id="DivTablaDetalle" class="card-box table-responsive">

                        <div class="col-12 mb-2">
                        <input type="text" id="buscador_general_detalle" name="buscador_general_detalle" class="form-control resize-input btn-round" placeholder="Buscar..." autocomplete="off">
                       </div>

                       <table id="tabla-maestra-detalle" class="table tbl_out_margin jambo_table" style="width: 100%">
                         <thead>
                           <tr>
                             <th>Identificador</th>
                             <th>Valor</th>
                             <th>Descripción</th>
                             <th>Activo</th>
                             <th>Fe.Creación</th>
                             <th>Acción</th>
                           </tr>
                         </thead>
                       </table>
                      </div> 
                           
                    </div>
             </div>
        </div>
</div>
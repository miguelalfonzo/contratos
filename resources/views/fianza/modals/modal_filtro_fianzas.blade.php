
<div id="modal_filtrar_cartas"class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
              <div class="modal-content">
                   
                  <div class="modal-header">

                          <div class="col-sm-9">
                            
                            <h3 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-search icon-right"></i>Filtrar Carta Fianza</span></h3>

                          </div>
                          
                          <div class="col-sm-3">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                                                   

                          </div>
                          
                    </div>
                    <div class="modal-body">

                      <div class="row">
  
                          <div class="col-12 ">
        
                                <form>

                                  <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                                      <div class="form-group row resize-margin-top-12 mb-0 ">
                                          
                                          
                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Cliente</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                          </div>

                                          <input type="hidden" name="filtrar_modal_id_cliente" id="filtrar_modal_id_cliente">


                                            <input type="text" class="font-size-12  form-control has-feedback-left form-control-sm"   id="filtrar_modal_cliente" name="filtrar_modal_cliente" value="" autocomplete="off">

                                            <div id="clientes_list" class="list-autocompletar"></div>
                                          </div>

          
                                          </div>

                                          <!--  -->

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Obra</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                          </div>

                                            
                                            <input type="hidden" name="filtrar_modal_id_obra" id="filtrar_modal_id_obra">


                                            <input type="text" class="font-size-12  form-control has-feedback-left form-control-sm"   id="filtrar_modal_obra" name="filtrar_modal_obra" value="" autocomplete="off">

                                            <div id="obras_list" class="list-autocompletar"></div>

                                          </div>

          
                                          </div>

                                          <!--  -->

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Carta</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          

                                            <select class="chosen" id="filtrar_modal_carta" name="filtrar_modal_carta">
                                              <option value="" selected>TODOS</option>
                                              <option value="AM">Adelanto Materiales</option>
                                              <option value="FC">Fiel Cumplimiento</option>
                                              <option value="AD">Adelanto Directo</option>
                                            </select>


                                            
                                          </div>

          
                                          </div>

                                          <!--  -->

                                         
                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Fianzas</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          

                                            <select class="chosen" id="filtrar_modal_vence" name="filtrar_modal_vence">
                                              
                                              <option value="TO">TODOS</option>
                                              <option value="VH">Que Vencen Hoy</option>
                                              <option value="VE">Vencidas</option>
                                              <option value="PV">Por Vencer</option>
                                              <option value="PE">Pendientes</option>
                                            </select>


                                            
                                          </div>

          
                                          </div>

                                          <!--  -->


                                          


                                          <div class="col-md-12 col-sm-12 margin-top-10">
                                
                                            <button id="buscar_fianzas_filtro" type="button" style="float:right;"class="btn btn-dark btn-sm resize-button"><i class="fa fa-check mr-2"></i>Filtrar</button>
          
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


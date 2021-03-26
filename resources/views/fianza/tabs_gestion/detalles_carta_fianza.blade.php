<style type="text/css">
  
  .form-control {
    padding-left: 10px!important;
} 


</style>

<div class="row">

        <div class="col-12">
          <div class="x_panel m-0 p-0">
          <div class="x_content pb-0">
                  
                  <form method="POST" action="" id="form_gestion_carta_fianza" novalidate="">
                  <div class="modal-body">
                      
                      <div class="row">

                      
                      <div class="col-12 ">
                        <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                            <div class="form-group row resize-margin-top-12 mb-0 ">

                               <label class="control-label col-md-2 col-sm-2 margin-top-10">Cliente</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">
                                
                                  
                              
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>

                                    <input type="hidden" name="id_mcf_id_solicitud" id="id_mcf_id_solicitud">

                                    <input type="hidden" name="id_mcf_hidden" id="id_mcf_hidden">

                                    <input type="hidden" name="tipo_carta_mcf_hidden" id="tipo_carta_mcf_hidden">


                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"   id="mcf_cliente" name="mcf_cliente" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="" readonly>
                                  </div>

          
                                </div>
                                
                                
                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Contratante</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"  id="mcf_contratante" name="mcf_contratante" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="" readonly>
                                  </div>


                                </div>

                              <!--   ------------- -->

                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Entidad Financiera</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">


                                  <input type="hidden" name="hidden_carta_idfinanciero" id="hidden_carta_idfinanciero" value="0">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="font-size-12  form-control has-feedback-left form-control-sm"   id="mcf_entidad_financiera" name="mcf_entidad_financiera" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="" >

                                    <div id="financiera_list" class="list-autocompletar"></div>

                                  </div>



                                </div>
                                
                                

                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Obra</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">


                      
                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-home"></i></div>
                                    </div>
                                    <input type="text" class="disable-buton font-size-12  form-control has-feedback-left form-control-sm"   id="mcf_name_obra" name="mcf_name_obra" autocomplete="off" maxlength="100" value="" readonly>

                                    

                                  </div>



                                </div>
                                
                                

                          <!--   --------------  -->

                            </div>

                            </div>
                          </div>
                          
                        </div>


                    <!-- ---------------parecen en tabla------------ -->

                      <div class="col-xl-8  col-md-12 ">
                          <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                              
                               
                              <div class="form-group row resize-margin-top-12 mb-0">

                                  <div style="display: none">
                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° File (Cod Obra)</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  id="mcf_file" name="mcf_file"  autocomplete="off" maxlength="20" value="" readonly>
                                    </div>

                                  </div>
                                  </div>


                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Tipo Carta</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <input type="text" class="font-size-11 disable-buton form-control has-feedback-left form-control-sm"  id="mcf_tipo_carta" name="mcf_tipo_carta"  autocomplete="off" maxlength="20" value="" readonly>

                                  </div>

                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° File</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"   id="mcf_fianza" name="mcf_fianza"  autocomplete="off" maxlength="100" value="" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Solicitud</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"   id="mcf_solicitud" name="mcf_solicitud"  autocomplete="off" maxlength="100" value="" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Moneda</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">
                                    <select class="chosen" name="mcf_moneda" id="mcf_moneda">
                                      
                                      @foreach($monedas as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>

                                  <!----------------->
                                  
                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Estado</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">
                                    <select class="chosen" name="mcf_estado" id="mcf_estado">
                                        
                                        @foreach($estados as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach


                                    </select>
                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Monto</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-money"></i></div>
                                      </div>
                                    <input data-gestion="" type="text" class="form-control has-feedback-left form-control-sm"   id="mcf_monto" name="mcf_monto"  oninput='limitDecimalPlaces(event, 2)'  onkeypress='return isNumberKey(event)' autocomplete="off" maxlength="12" value="">
                                    </div>

                                  </div>

                                  
                                
                                <!--   ------------- -->

                                 <label class="control-label col-xl-3 col-sm-2 margin-top-10">Fecha</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">

                                  <div class="input-group mb-2 mr-sm-2 ">
                                   
                                    <input type="date" name="mfc_fecha" id="mfc_fecha" class="form-control form-control-sm" value="" required>
                                  </div>

                                </div>

                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° de Carta F.</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class=" form-control has-feedback-left form-control-sm"  placeholder="" id="mfc_carta_manual" name="mfc_carta_manual"  autocomplete="off" maxlength="20" value="" >
                                </div>

                                  

                            <!----------------->

                              <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">Fecha Inicio</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                   <input type="date" name="mfc_fecha_inicio" id="mfc_fecha_inicio" class="form-control form-control-sm" value="" required>
                                </div>
                                <!----------------->
                                

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">Dias</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class="numerosenteros form-control has-feedback-left form-control-sm"   id="mfc_dias" name="mfc_dias"  autocomplete="off" maxlength="3" value="">
                                </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">Vencimiento</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class="disable-buton form-control has-feedback-left form-control-sm" id="mfc_vencimiento" name="mfc_vencimiento" autocomplete="off" readonly value="">
                                </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° Renovación</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="mfc_renovacion" name="mfc_renovacion" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="" readonly>
                                </div>

                                  

                            <!----------------->



                             
                              </div>

                            </div>
                          </div>
                          
                        </div>

                        <div class="col-xl-4 col-md-12">
                          <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                                  <div class="card-box table-responsive" >

                           
                                  <table id="table-documentos-gestion-documentos" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                                
                                  <thead>
                                   <tr>
                                      <th>Documento</th>
                                      
                                      <th>Accion</th>   
                                                                         
                                   </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Documento Electrónico</td>
                                      
                                      <td><div class="btn-group"><a data-file=""  class="btn btn-default btn_resize" style="cursor: pointer;display: none" onclick="ver_documento_gestion_carta_fianza()"><span class="text-success glyphicon glyphicon-eye-open" style="font-size:80%;"></span></a>
                                        <button type="button" class="btn btn-default btn_resize" style="cursor: pointer;" onclick="upload_documento_gestion_carta_fianza()"><span class="text-primary glyphicon glyphicon-cloud" style="font-size:80%;"></span></button>
                                        <a data-file="" class="btn btn-default btn_resize"  style="cursor: pointer;;display: none" onclick="elimina_documento_gestion_carta_fianza()"><span class="text-danger glyphicon glyphicon-remove" style="font-size:80%;"></span></a></div></td>
                                    </tr>
                                  </tbody>
                                 
                              
                                  </table>
                                  </div>

                                  

                                   

                            </div>
                          </div>


                          <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                                  <div class="card-box table-responsive" >

                           
                                  <textarea id="mfc_observacion" name="mfc_observacion" style="height:90px;resize: none" class="form-control" placeholder="Observacion"></textarea>
                                  </div>

                                  

                                   

                            </div>
                          </div>
                          <div style="margin-top: 10px">
                          <button type="submit" class="btn btn-success resize-button btn-sm" style="float: right;" id="btn_save_modal_cf"><i class="fa fa-save mr-2" ></i>Guardar</button>

                          <button type="button" id="btn_close_modal_cf"class="btn btn-danger resize-button btn-sm" style="float: right;"><i class="fa fa-close mr-2" ></i>Cancelar</button>
                          </div>

                        </div>



                    </div>
                    </div>

                  </form>

                  
                  
            </div>
          </div>
        </div>

    </div>
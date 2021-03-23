<div class="row">
<form method="POST" action="" id="form_renovar_carta">
                     <!----------------------  mdr = modal_datos_renovacion ------------------->
                      <div class="col-12 ">
                        <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                            <div class="form-group row resize-margin-top-12 mb-0 ">

                               <label class="control-label col-md-2 col-sm-2 margin-top-10">Cliente</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">
                                  

                                  <input type="hidden" name="mdr_numero_carta" id="mdr_numero_carta">


                                  <input type="hidden" name="mdr_hidden_cliente" id="mdr_hidden_cliente">

                                  <input type="hidden" name="mdr_hidden_beneficiario" id="mdr_hidden_beneficiario">

                                  <input type="hidden" name="mdr_hidden_financiera" id="mdr_hidden_financiera">

                                  <input type="hidden" name="mdr_hidden_idSolicitud" id="mdr_hidden_idSolicitud">
                                  
                                  <input type="hidden" name="mdr_hidden_idCartaFianza" id="mdr_hidden_idCartaFianza">



                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>

                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_cliente" name="mdr_cliente" autocomplete="off" maxlength="100" readonly>
                                  </div>

          
                                </div>
                                
                                
                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Beneficiario</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm" placeholder="" id="mdr_beneficiario" name="mdr_beneficiario" autocomplete="off" maxlength="100" readonly>
                                  </div>


                                </div>

                              <!--   ------------- -->

                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Entidad Financiera</label>

                                <div class="col-md-4 col-sm-4 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    <div class="input-group-prepend ">
                                      <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" class="font-size-12 disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_entidad_financiera" name="mdr_entidad_financiera"  autocomplete="off" maxlength="100" readonly>
                                  </div>



                                </div>
                                <!--   ------------- -->

                                <!--   ------------- -->

                                <label class="control-label col-md-2 col-sm-2 margin-top-10">Monto Carta</label>

                                <div class="col-md-2 col-sm-2 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"   id="mdr_tipo_mon_cf_old" name="mdr_tipo_mon_cf_old"  autocomplete="off"  readonly>
                                  </div>



                                </div>

                                <div class="col-md-2 col-sm-2 margin-top-10">

                                
                                  <div class="input-group mb-2 mr-sm-2 ">
                                    
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"   id="mdr_moneda_cf_old" name="mdr_moneda_cf_old"  autocomplete="off"  readonly>
                                  </div>



                                </div>
                                <!--   ------------- -->
                                
                              
                          <!--   --------------  -->
                            </div>

                            </div>
                          </div>
                          
                        </div>


                    <!-- ---------------parecen en tabla------------ -->

                      <div class="col-xl-8  col-md-12 ">
                          <div class="x_panel m-0">
                          <div class="x_content pb-0">
                              
                               
                              <div class="form-group row resize-margin-top-12 mb-0">

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° Interno(Cod obra)</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_interno" name="mdr_interno"  autocomplete="off" maxlength="20" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Tipo Fianza</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <select class="chosen" id="mdr_cmbtipo_fianza" name="mdr_cmbtipo_fianza">
                                      @foreach($tipo_cartas as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>

                                  </div>
                                  <!----------------->

                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Número Carta</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_fianza" name="mdr_fianza"  autocomplete="off" maxlength="100" value="">
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° Solicitud</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_solicitud" name="mdr_solicitud"  autocomplete="off" maxlength="100" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Moneda</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">
                                      <select class="chosen" id="mdr_cmb_moneda" name="mdr_cmb_moneda">
                                      @foreach($monedas as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>

                                 
                                  <!----------------->

                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Monto</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-money"></i></div>
                                      </div>
                                    <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_monto" name="mdr_monto"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)'  onkeypress='return isNumberKey(event)' maxlength="100" value="">
                                    </div>

                                  </div>

                                   <!----------------->
                                  
                                  <label class="control-label col-xl-3 col-sm-2 margin-top-10">Estado</label>
                                  <div class="col-xl-3 col-sm-4 margin-top-10">
                                    <select class="chosen" name="mdr_estado" id="mdr_estado">
                                       @foreach($estados as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>

                                  
                                
                                <!--   ------------- -->

                                 <label class="control-label col-xl-3 col-sm-2 margin-top-10">Fecha Creación</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">

                                  <div class="input-group mb-2 mr-sm-2 ">
                                   
                                    <input type="date" required name="mdr_fecha" id="mdr_fecha" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
                                  </div>

                                </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">Fecha Inicio</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                   <input type="date" name="mdr_fecha_inicio" id="mdr_fecha_inicio" class="form-control form-control-sm" value="">
                                </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">Dias</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class="numerosenteros form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_dias" name="mdr_dias"  autocomplete="off" maxlength="15" value="">
                                </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">Fecha Vencimiento</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class="disable-buton form-control has-feedback-left form-control-sm" id="mdr_vencimiento" name="mdr_vencimiento" autocomplete="off" readonly value="">
                                </div>
                                <!----------------->

                                <label class="control-label col-xl-3 col-sm-2 margin-top-10">N° Renovación</label>
                                <div class="col-xl-3 col-sm-4 margin-top-10">
                                  <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"  placeholder="" id="mdr_renovacion" name="mdr_renovacion" autocomplete="off" maxlength="100" readonly>
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

                           
                                  <table id="table-renovacion-carta" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                                
                                  <thead>
                                   <tr>
                                      <th>Documento</th>
                                      
                                      <th>Accion</th>   
                                                                         
                                   </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Avance de Obra</td>
                                      
                                      <td><div class="btn-group"><a data-file=""  class="btn btn-default btn_resize" style="cursor: pointer;display: none" onclick="ver_documento_avance_obra()"><span class="text-success glyphicon glyphicon-eye-open" style="font-size:80%;"></span></a>
                                        <button type="button" class="btn btn-default btn_resize" style="cursor: pointer;" onclick="upload_documento_avance_obra()"><span class="text-primary glyphicon glyphicon-cloud" style="font-size:80%;"></span></button>
                                        <a data-file="" class="btn btn-default btn_resize"  style="cursor: pointer;;display: none" onclick="elimina_documento_avance_obra()"><span class="text-danger glyphicon glyphicon-remove" style="font-size:80%;"></span></a></div></td>
                                    </tr>
                                  </tbody>
                                 
                              
                                  </table>
                                  </div>

                                  

                                   {{-- <div class="col-12  margin-top-10 ">
                                    <button type="submit" id="mdr_guardar_renovar_cf" class="btn btn-success resize-button" style="float:right;"><i class="fa fa-save mr-2"> </i>Renovar</button>
                                  </div> --}}

                            </div>
                          </div>

                          <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                                  <div class="card-box table-responsive" >

                                      <textarea id="mdr_observacion" placeholder="Comentario" name="mdr_observacion" class="form-control" style="resize: none;"></textarea>
                                  
                                  </div>

                                  

                                   <div class="col-12  margin-top-10 ">
                                    <button type="submit" id="mdr_guardar_renovar_cf" class="btn btn-success resize-button" style="float:right;"><i class="fa fa-save mr-2"> </i>Renovar</button>
                                  </div>

                            </div>
                          </div>
                        </div>
</form>
                    </div>
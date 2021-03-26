

<div id="modal_renovar_garantias_garantias"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                   
                  <div class="modal-header">

                          <div class="col-sm-9">
                            
                            <h3 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Renovar Garantía </span></h3>

                          </div>
                          
                          <div class="col-sm-3">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                                                   

                          </div>
                          
                    </div>


                    <div class="modal-body">
                      
                      <div class="x_content" >
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="card-box table-responsive ">

                            <table id="table-modificar-montos-garantias" class="table tbl_out_margin  jambo_table letra-size-tablas table-striped" style="width: 100%"> 

                                <thead style="width: 100%">
                                  <tr>
                                    
                                    <th >Fecha</th>
                                    <th >Tipo de Garantía</th>
                                    <th >Nro Documento</th>  
                                    <th >Monto Fianza</th> 
                                    <th >(%)</th> 
                                    <th >Monto</th> 
                                    <th >Emisión</th> 
                                    <th >Vence</th> 
                                    <th >Cobro</th>                                   
                                    <th >Disponible</th>
                                    <th >Estado</th> 
                                    
                                    <th ><i class="fa fa-edit"></i></th> 
                                    <th ><i class="fa fa-check-circle"></i></th>       
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
                            <form method="POST" action="" id="form_renovar_garantia">

                            <div class="row">
                                

                                <div class="col-12 ">
                        <div class="x_panel m-0 ">
                          <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                            <div class="form-group row  mb-0 ">

                                  <input type="hidden" name="ren_car_gar_idgarantia" id="ren_car_gar_idgarantia" value="0">


                                  <input type="hidden" name="ren_car_gar_codigo_sol" id="ren_car_gar_codigo_sol" value="0">
                                  <input type="hidden" name="ren_car_gar_num_ca" id="ren_car_gar_num_ca" value="0">
                                  <input type="hidden" name="ren_car_gar_tipo_carta" id="ren_car_gar_tipo_carta" value="0">


                                <label class="control-label col-md-1 col-sm-2 ">Estado</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <select class="chosen" name="ren_car_gar_estados_gar" id="ren_car_gar_estados_gar">
                                      
                                      @foreach($estados_garantias as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>



                                </div>


                               
                                
                                
                                <label class="control-label col-md-1 col-sm-2">Monto Fianza</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input maxlength="12" type="text" data-mofianza="" class="font-size-12  form-control has-feedback-left form-control-sm"  id="ren_car_gar_monto_fianza" name="ren_car_gar_monto_fianza" autocomplete="off" onkeyup="recalcula_montos_renovar_garantia()" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)'>
                                  </div>


                                </div>

                              <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Emisión</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input type="date" class="font-size-12  form-control has-feedback-left form-control-sm" id="ren_car_gar_emision" name="ren_car_gar_emision" autocomplete="off" required>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Tipo</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <select class="chosen" name="ren_car_gar_tipo_pago" id="ren_car_gar_tipo_pago">
                                      
                                      @foreach($tipo_pagos as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Número</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input type="text" class="font-size-12  form-control has-feedback-left form-control-sm"  placeholder="" id="ren_car_gar_numero" name="ren_car_gar_numero"  autocomplete="off" maxlength="20" >
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Porcentaje</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input type="text" data-porcentaje=""class="font-size-12 form-control has-feedback-left form-control-sm"   id="ren_car_gar_porcentaje" name="ren_car_gar_porcentaje"  autocomplete="off" onkeyup="recalcula_montos_renovar_garantia()" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)'>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Moneda</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <select class="chosen" name="ren_car_gar_moneda" id="ren_car_gar_moneda">
                                      
                                      @foreach($monedas as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Vencimiento</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input type="date" class="font-size-12  form-control has-feedback-left form-control-sm" id="ren_car_gar_vencimiento" name="ren_car_gar_vencimiento" autocomplete="off" required>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Banco</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <select class="chosen" name="ren_car_gar_bancos" id="ren_car_gar_bancos">
                                      
                                      @foreach($bancos as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Monto</label>

                                <div class="col-md-3 col-sm-4">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input maxlength="12" type="text" data-monto="" class="font-size-12 form-control has-feedback-left form-control-sm"   id="ren_car_gar_monto" name="ren_car_gar_monto"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' readonly="">
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Fecha Cobro</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                   <input type="date" class="font-size-12  form-control has-feedback-left form-control-sm" id="ren_car_gar_cobro" name="ren_car_gar_cobro" autocomplete="off" >
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <!-- <label class="control-label col-md-1 col-sm-2 ">Estado</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <select class="chosen" name="ren_car_gar_estados_gar" id="ren_car_gar_estados_gar">
                                      
                                      @foreach($estados_garantias as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>



                                </div> -->
                              
                                <label class="control-label col-md-1 col-sm-2 ">F.Creación</label>

                                <div class="col-md-3 col-sm-4 ">
                                
                                  


                                  <div class=" mb-2 mr-sm-2 ">
                                    

                                    <input type="date" class="font-size-12  form-control has-feedback-left form-control-sm" id="ren_car_gar_fecha" name="ren_car_gar_fecha" autocomplete="off" readonly>
                                  </div>

          
                                </div>
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Disponible</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input maxlength="12" type="text" data-disponible=""class="disable-buton font-size-12 form-control has-feedback-left form-control-sm"   id="ren_car_gar_disponible" name="ren_car_gar_disponible"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' readonly="">
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                           <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Liberar</label>

                                <div class="col-md-3 col-sm-4">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input maxlength="12" type="text" class="disable-buton font-size-12 form-control has-feedback-left form-control-sm"   id="ren_car_gar_liberar" name="ren_car_gar_liberar"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)' onkeypress='return isNumberKey(event)' readonly>
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->

                          <!--   ------------- -->

                                <label class="control-label col-md-1 col-sm-2 ">Observación</label>

                                <div class="col-md-3 col-sm-4 ">

                                
                                  <div class=" mb-2 mr-sm-2 ">
                                    
                                    <input type="text" class="font-size-12  form-control has-feedback-left form-control-sm"  placeholder="" id="ren_car_gar_obs" name="ren_car_gar_obs"  autocomplete="off" maxlength="100" >
                                  </div>



                                </div>
                              
                                
                              
                          <!--   --------------  -->
                            </div>

                            </div>
                          </div>
                          
                        </div>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" id="btn_save_renovar_garantia" class="btn btn-primary resize-button btn-sm"><i class="fa fa-refresh mr-2"></i>Renovar</button>
                                <button onclick="cierra_modal_renovar_garantias()"type="button"class="btn btn-danger resize-button btn-sm"><i class="fa fa-trash mr-2"></i>Cancelar</button>
                             </div>

                           </form>
                    </div>



              </div>

        </div>
</div>


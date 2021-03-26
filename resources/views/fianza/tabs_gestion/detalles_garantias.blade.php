<div class="row">

        <div class="col-12">
          <div class="x_panel m-0 ">
          <div class="x_content pb-0">
                  
                  <div class="form-group row resize-margin-top-12">

                                  <input type="hidden" name="hidden_id_garantia_last" id="hidden_id_garantia_last" value="0">

                                  
                                  <label class="control-label col-sm-2 margin-top-10">Tipo Garantía</label>
                                  <div class="col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <select class="chosen" name="mdg_tipo_garantia" id="mdg_tipo_garantia">
                                        <option value="CD">CHEQUE DIFERIDO</option>
                                        <option value="DE">DEPOSITO</option>
                                        <option value="CH">CHEQUE</option>
                                      </select>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-sm-2 margin-top-10">N° Garantía</label>
                                  <div class="col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</i></div>
                                      </div>
                                    <input type="text" class=" form-control has-feedback-left form-control-sm"   id="mdg_n_tipo_garantia" name="mdg_n_tipo_garantia"  autocomplete="off" maxlength="20" value="" >
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label col-sm-2 margin-top-10">Monto Fianza</label>
                                  <div class="col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-calculator"></i></div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"   id="mdg_monto_fianza" name="mdg_monto_fianza"  autocomplete="off" maxlength="12" value="" readonly>
                                    </div>

                                  </div>
                                  <!----------------->

                                  <label class="control-label  col-sm-2 margin-top-10">Banco</label>
                                  <div class=" col-sm-4 margin-top-10">
                                    <select class="chosen" name="mdg_banco" id="mdg_banco" >

                                      

                                     @foreach($bancos as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>  
                                    

                                   <!----------------->

                                  <label class="control-label  col-sm-2 margin-top-10">Moneda</label>
                                  <div class=" col-sm-4 margin-top-10">
                                    <select class="chosen" name="mdg_moneda" id="mdg_moneda">
                                      @foreach($monedas as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                    </select>
                                  </div>   

                                  <!----------------->

                                  <label class="control-label  col-sm-2 margin-top-10">(%)</label>
                                  <div class=" col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px"><i class="fa fa-calculator"></i></div>
                                      </div>
                                    <input type="text" class=" form-control has-feedback-left form-control-sm"   id="mdg_porcentaje" name="mdg_porcentaje"  autocomplete="off" oninput='limitDecimalPlaces(event, 2)' onkeyup='recalcula_monto_garantia()' onkeypress='return isNumberKey(event)' value="" >
                                    </div>

                                  </div> 

                                  <!----------------->

                                  <label class="control-label  col-sm-2 margin-top-10">Monto Garantía</label>
                                  <div class=" col-sm-4 margin-top-10">

                                    <div class="input-group mb-2 mr-sm-2 ">
                                      <div class="input-group-prepend ">
                                        <div class="input-group-text " style="height:31px">#</div>
                                      </div>
                                    <input type="text" class="disable-buton form-control has-feedback-left form-control-sm"   id="mdg_monto_garantia" name="mdg_monto_garantia"  autocomplete="off" maxlength="12" value="" readonly>
                                    </div>

                                  </div>                             
                                
                                <!--   ------------- -->

                                 <label class="control-label  col-sm-2 margin-top-10">Fecha Emisión</label>
                                <div class=" col-sm-4 margin-top-10">

                                  <div class="input-group mb-2 mr-sm-2 ">
                                   
                                    <input type="date" name="mdg_fecha_emision" id="mdg_fecha_emision" class=" form-control form-control-sm" value="" required >
                                  </div>

                                </div>
                                <!----------------->

                                <label class="control-label  col-sm-2 margin-top-10">Vencimiento</label>
                                <div class=" col-sm-4 margin-top-10">
                                  <input type="text" class="disable-buton form-control has-feedback-left form-control-sm" id="mdg_vencimiento" name="mdg_vencimiento" autocomplete="off" readonly value="">
                                </div>
                                <!----------------->

                                <label class="control-label  col-sm-2 margin-top-10">Estado</label>
                                <div class=" col-sm-4 margin-top-10">
                                  <select class="chosen" name="mdg_estado" id="mdg_estado" >
                                    
                                    @foreach($estados_garantias as $list)

                                        <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                        @endforeach
                                  </select>
                                </div>

                                 
                                   <!----------------->

                                <label class="control-label  col-sm-2 margin-top-10">Observación</label>
                                <div class="col-xl-6 col-sm-10 margin-top-10">

                                   <textarea  maxlength="255" class="form-control has-feedback-left form-control-sm"   id="mdg_obs"  name="mdg_obs" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" style="height:100px;resize: none;">
                                  </textarea>


                                </div>


                            <!----------------->
                                

                              </div>

                  
            </div>
          </div>
        </div>

    </div>
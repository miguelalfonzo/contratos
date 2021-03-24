<style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 




</style>
<div id="modal-edit-representante"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  <form >
                    
                   
                  <div class="modal-header">

                          <div class="col-md-9 col-sm-7">
                            
                            <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Representante Legal - <span id="lbl_cabecera_representante"></span></span></h6>

                          </div>
                          
                          <div class="col-md-3 col-sm-5">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                            <button class=" btn btn-sm resize-button btn-dark" style="float: right;" id="btn_nuevo_representante"><i class="fa fa-plus mr-2"></i>Nuevo
                           </button>


                          

                          </div>
                          
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">

                      
                      

                      <div class="col-md-12 col-sm-12">
                      <div class="form-group row ">
                        
                        
                        <label class="control-label col-md-2 col-sm-2 margin-top-10">Dni</label>

                        <div class="col-md-4 col-sm-4 margin-top-10">
                        
                          
                      
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px">#</div>
                            </div>

                           


                            <input type="text" class="numerosenteros form-control has-feedback-left form-control-sm"  placeholder="Dni" id="representante_dni" name="representante_dni"  autocomplete="off" maxlength="8" value="">

                            <span class="input-group-btn" style="height:31px;" >
                            <button  data-type="representante" type="button" class="span_find_ruc_representante btn btn-primary btn-sm "><i class="fa fa-search"></i></button>
                            </span>

                          </div>

  
                        </div>

                        
                        <label class="control-label col-md-2 col-sm-2 margin-top-10">Fe. Nacimiento</label>

                        <div class="col-md-4 col-sm-4 margin-top-10">
                        
                          
                     
                            <input type="date" class=" form-control has-feedback-left form-control-sm"   id="representante_fe_nac" name="representante_fe_nac"  autocomplete="off" >

  
                        </div>




                         <label class="control-label col-md-2 col-sm-2 margin-top-10">Nombres</label>

                        <div class="col-md-4 col-sm-4 margin-top-10">
                        
                          
                      
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>

                            <input type="hidden" name="id_representante_cliente_hidden" id="id_representante_cliente_hidden" value="0">

                            <input type="hidden" name="id_cliente_hidden" id="id_cliente_hidden">


                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="Nombres" id="representante_nombre" name="representante_nombre" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="">
                          </div>

  
                        </div>
                        
                        
                        <label class="control-label col-md-2 col-sm-2 margin-top-10">Apellido Paterno</label>

                        <div class="col-md-4 col-sm-4 margin-top-10">

                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm" placeholder="A.Paterno" id="representante_pat" name="representante_pat" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="">
                          </div>


                        </div>
                        
                        

                      </div>

                      <div class="form-group row resize-margin-top">
                        
                        <label class="control-label col-md-2 col-sm-2 margin-top-10">Apellido Materno</label>

                        <div class="col-md-4 col-sm-4 margin-top-10">

                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control has-feedback-left form-control-sm"  placeholder="A.Materno" id="representante_mat" name="representante_mat" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100" value="">
                          </div>



                        </div>
                        
                        <label class="control-label col-md-2 col-sm-2 margin-top-10">Fecha Inicio</label>

                        <div class="col-md-4 col-sm-4 margin-top-10">

                      
                           <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-calculator"></i></div>
                            </div>
                            <input type="date" name="representante_feini" id="representante_feini" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
                          </div>



                        </div>

                        <label class="control-label col-md-2 col-sm-2 margin-top-10">Fecha Fin</label>
                        <div class="col-md-4 col-sm-4 margin-top-10">

                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-calculator"></i></div>
                            </div>
                           <input type="date" name="representante_fefin" id="representante_fefin" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
                          </div>

                        </div>


                        
                        <label class="control-label col-md-2 col-sm-2 margin-top-10"> Cargo</label>
                        <div class="col-md-3 col-sm-4 margin-top-10">
                          <select class="chosen" id="cargos_representante" name="cargos_representante">
                            
                                @foreach($cargos as $values)

                                  <option value="{{$values->Valor}}">{{$values->Descripcion}}</option>
                                    
                                @endforeach
                          </select>
                        </div>

                        <div class="col-md-1 col-sm-4 margin-top-10">
                          <button  id="salvar_representante" class="btn btn-success resize-button" ><i class="fa fa-save"></i></button>
                        </div>
                        
                      </div>
      
                      

                      <div class="card-box table-responsive" >

                            
                  <table id="table-cliente-representantes" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                
                    <thead>
                    <tr>
                      <th>Dni</th>
                      <th>Representante</th>
                      <th>Cargo</th>   
                      <th>Periodo</th>                   
                      <th><i class="fa fa-edit"></i></th>                                   
                   </tr>
                  </thead>
                
                  </table>
                  </div>


                      </div>
        

                    </div>
                    </div>

                          

                    
                    </form>




                    

              </div>

        </div>
</div>
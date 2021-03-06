


<div id="modal-filtrar-obras"class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
              <div class="modal-content">
                  
                    
                   
                  <div class="modal-header">

                          <h6 class="modal-title text-success" ><span class="badge badge-dark"><i class="fa fa-search icon-right"></i>Filtrar Obras</span></h6>

                          <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          
                    </div>
                    <div class="modal-body">

                      <div class="row">
  
                          <div class="col-12 ">
        
                               

                                  <div class="x_content pb-0">
                           <!--  resize-margin-top-12 -->
                             
                                      <div class="form-group row resize-margin-top-12 mb-0 ">
                                          
                                          
                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Proceso</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                                          <select class="chosen" id="filter_obra_proceso" name="filter_obra_proceso">
                                              <option value="0">TODOS</option>
                                              <option value="PND">PENDIENTES</option>
                                              <option value="GEN">GENERADOS</option>
                                              <option value="REC">RECHAZADO</option>
                                            </select>

          
                                          </div>

                                          <!--  -->

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Condición</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                                          <select class="chosen" id="filter_obra_condicion" name="filter_obra_condicion">

                                              <option value="0">TODOS</option>
                                              @foreach($condicion as $list)

                                                <option value="{{$list->Valor}}">{{$list->Descripcion}}</option>
                                    
                                              @endforeach

                                            </select>

          
                                          </div>

                                          <!--  -->


                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Cliente</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-user"></i></div>
                                          </div>

                                  

                                            <input type="hidden" name="filter_obra_id_cliente" id="filter_obra_id_cliente" value="0">

                                            <input type="text" class="font-size-12  form-control  form-control-sm"   id="filter_obra_cliente" name="filter_obra_cliente" value="" >

                                            <div id="clientes_list" class="list-autocompletar"></div>

                                          </div>

          
                                          </div>

                                          <!--  -->

                                          
                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Obra</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-home"></i></div>
                                          </div>

                                  

                                            <input type="hidden" name="filter_obra_idobra" id="filter_obra_idobra" value="0">


                                            <input type="text" class="font-size-12  form-control  form-control-sm"   id="filter_obra_obra" name="filter_obra_obra" value="" autocomplete="off">

                                            <div id="obras_list" class="list-autocompletar"></div>

                                          </div>

          
                                          </div>

                                          <!--  -->
                                          

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Inicio</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-calendar"></i></div>
                                          </div>

                                  

                                            


                                            <input type="date" class="font-size-12  form-control  form-control-sm"   id="fecha_inicio_filter_obra" name="fecha_inicio_filter_obra" value="<?php echo date('Y-01-01')?>" required>

                                            

                                          </div>

          
                                          </div>

                                          <!--  -->
                                         

                                          <!--   -->
                                          <label class="control-label col-md-2 col-sm-2 margin-top-10">Fin</label>

                                          <div class="col-md-10 col-sm-10 margin-top-10">
                                
                                  
                              
                                          <div class="input-group mb-2 mr-sm-2 ">
                                          <div class="input-group-prepend ">
                                            <div class="input-group-text " style="height:28px"><i class="fa fa-calendar"></i></div>
                                          </div>

                                  

                                            


                                            <input type="date" class="font-size-12  form-control  form-control-sm"   id="fecha_fin_filter_obra" name="fecha_fin_filter_obra" value="<?php echo date('Y-m-d')?>" required>

                                            

                                          </div>

          
                                          </div>

                                          <!--  -->

                                         


                                          <div class="col-md-12 col-sm-12 margin-top-10">
                                
                                            <button style="float:right;"class="btn btn-success btn-sm resize-button" id="aplica_filtro_obras"><i class="fa fa-check mr-2"></i>Buscar</button>
          
                                          </div>

                                      </div>

                                  </div>

                                

                          </div>

                      </div>
                            
                    </div>

                          

                    
                    




                    

              </div>

        </div>
</div>




  


    

   
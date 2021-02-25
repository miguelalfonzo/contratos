<style type="text/css">
  
.form-control {
    padding-left: 10px!important;
} 

</style>

 

<div class="modal-content">

                  <div class="modal-header">
                          <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right" ></i>@if(isset($rol)) Editar - {{$rol->Rol}} @else Nuevo @endif Rol</span></h6>
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                    </div>
                    <div class="modal-body">

                      <input type="hidden" id="id_rol" value="{{$rol->IdRol??0}}">

                      <div class="form-group row resize-margin-top">


                        <label class="control-label col-lg-1  ">Rol</label>
                        

                        <div class="col-lg-4 ">
                        
                        
                          <div class="input-group mb-2 mr-sm-2 ">
                            <div class="input-group-prepend ">
                              <div class="input-group-text " style="height:31px"><i class="fa fa-user"></i></div>
                            </div>
                            <input style=""type="text" class="form-control has-feedback-left form-control-sm"  placeholder="" id="descripcion_rol" name="descripcion_rol" onkeypress="return validateAlfaNumerico(event);" autocomplete="off" maxlength="100"  value="{{$rol->Rol??''}}">
                          </div>

  
                        </div>

                        

                        <label class="control-label col-lg-2  ">Estado</label>
                        <div class="col-lg-3 ">
                          <select class="chosen" id="estados_rol">
                           
                             @foreach($estados as $values)

                                  <option value="{{$values->Valor}}" {{ $values->Valor == ($rol->FlagActivo??1) ? "selected":"" }}>{{$values->Descripcion}}</option>
                                    
                                @endforeach
                          </select>
                        </div>


                        <div class="col-lg-2  mt-4 mt-lg-0">

                          <a class="panel-heading btn btn-warning resize-button" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-lock icon-right margin-top-5"></i>Permisos</a>
                          
                         
                        </div>

                        

                      </div>

                      
                      

                      

                      <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body ">
                            <?php
                              $i=0;
                            ?>
                            @foreach($menu_list as $key=>$list)
                                
  
                                  @if($list->IdMenuPadre==1)
                                      
                                      <div class="col-md-4 col-sm-4 margin-top-10">
                                      <div class="x_panel">

                                      <div class="x_title">
                                      <h2> <i class="{{$icons[$i]}}"></i><small>{{$list->Menu}}</small></h2>
                                      <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        
                                      </ul>
                                      <div class="clearfix"></div>
                                      </div>
                                          
                                          <div class="x_content">

                                    <div class="">
                                      <ul class="to_do">
                                        


                                      @foreach($menu_list as $value)
                                          @if(substr($value->CodMenu,0,2)==$list->CodMenu)
                                            
                                             <li>
                                                <p>
                                                <input type="checkbox" class="" name="RolChecksMultiple[]" id="RolChecksMultiple_{{$value->CodMenu }}" value="{{$value->IdMenu}}" @if(in_array($value->IdMenu,$options)) checked @endif> &nbsp;{{$value->Menu}}</p>
                                              </li>
                                        @endif
                                      @endforeach
                                       
                                      </ul>
                                    </div>
                                  </div>

                                      
                                  </div>
                              </div>
                                  <?php
                                    $i++;
                                  ?>
                                  @endif

                                
                            @endforeach

 
                          </div>
                        </div>
                      </div>
                      
                     
                    </div>
                    <!-- end of accordion -->


                    </div>
                    <div class="modal-footer">
                      
                      <button type="button" id="salvar_rol" class="btn btn-success resize-button"><i class="fa fa-edit icon-right margin-top-5"></i>Aceptar</button>


                    </div>

              </div>



<script src="{{asset('js/jsApp/save_rol.js')}}"></script>


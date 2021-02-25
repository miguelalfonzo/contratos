
<div id="modal_renovar_carta"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                   
                  <div class="modal-header">

                          <div class="col-sm-9">
                            
                            <h3 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Renovar Carta Fianza</span></h3>

                          </div>
                          
                          <div class="col-sm-3">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                                                   

                          </div>
                          
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">
                      
                       <ul class="nav nav-tabs w-100"  >
                         
                          <li class="nav-item" >
                            <a class="nav-link active"  data-toggle="tab" href="#renovar_datos_renovacion" id="tab-datos-renovacion-cf" role="tab">Datos Renovación</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#renovar_datos_garantia" role="tab">Datos Garantía</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#renovar_carta_fianza" role="tab">Cartas Fianzas Relacionadas</a>
                          </li>
                          

                          
                        </ul>


                        <div class="tab-content">
                         
                          <div class="tab-pane fade show active" id="renovar_datos_renovacion" role="tabpanel" >
                           @include('fianza.tabs.datos_renovacion')
                          </div>
                          <div class="tab-pane fade " id="renovar_datos_garantia" role="tabpanel" >
                            @include('fianza.tabs.datos_renovacion_garantia')
                          </div>
                          <div class="tab-pane fade" id="renovar_carta_fianza" role="tabpanel" >
                            @include('fianza.tabs.carta_fianza_relacionadas')
                          </div>
                          
                         
                        </div>


                    </div>
                    </div>



              </div>

        </div>
</div>




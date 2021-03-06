
<div id="modal_gestionar_carta"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                   
                  <div class="modal-header">

                          <div class="col-sm-9">
                            
                            <h3 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Gestionar Carta Fianza </span></h3>

                          </div>
                          
                          <div class="col-sm-3">

                            <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>

                                                   

                          </div>
                          
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">
                      
                       <ul class="nav nav-tabs w-100"  >
                          <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#detallesGestionCF" id="tab-gestion-cf" role="tab"  aria-selected="true">Datos Carta Fianza</a>
                          </li>
                          
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#detallesGestionGarantias" id="tab-gestion-garantia-cf" role="tab" aria-selected="false">Datos Garantía</a>
                          </li>
                          
                          

                          
                        </ul>


                        <div class="tab-content">
                          <div class="tab-pane fade show active" id="detallesGestionCF" role="tabpanel" >
                            @include('fianza.tabs_gestion.detalles_carta_fianza')
                          </div>
                          <div class="tab-pane fade " id="detallesGestionGarantias" role="tabpanel" >
                           @include('fianza.tabs_gestion.detalles_garantias')
                          </div>
                          
                         
                         
                        </div>


                    </div>
                    </div>



              </div>

        </div>
</div>




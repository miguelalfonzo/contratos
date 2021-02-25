
<div id="modal-create-dist" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"  role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-me" role="document">
              <div class="modal-content">
                  <div class="modal-header">

                          <h5 class="modal-title">
                            <span class="badge badge-dark"><i class="fa fa-th icon-right"></i></span>&nbsp<span class="badge badge-primary" id="title_ubigeo"></span></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                          </button>
                    </div>
                     

                    <div class="modal-body">
                      
                  
                  

                        <div class="form-group row negative-margin-top-4" id="div_id_ubigeo" hidden=""> 
                        <label class="control-label col-md-3 col-sm-3" >ID</label>
                          <div class="col-md-9 col-sm-9 ">
                          <input type="text" class="form-control resize-input resize-font"  
                          readonly="" id="ubigeo_id" autocomplete="off">          
                          </div>
                        </div>

                        <div class="form-group row negative-margin-top-4" id="div_dpto_ubigeo"> 
                        <label class="control-label col-md-3 col-sm-3" id="lbl_dpto"></label>
                          <div class="col-md-9 col-sm-9 ">
                          <input type="text" class="form-control resize-input resize-font"  id="ubigeo_departamento" autocomplete="off" onkeypress="return validateAlfaNumerico(event);">          
                          </div>
                        </div> 

                        <div class="form-group row negative-margin-top-4"  id="div_prov_ubigeo"> 
                        <label class="control-label col-md-3 col-sm-3" id="lbl_prov"></label>
                          <div class="col-md-9 col-sm-9 ">
                          <input type="text" class="form-control resize-input resize-font"  id="ubigeo_provincia" autocomplete="off" onkeypress="return validateAlfaNumerico(event);">          
                          </div>
                        </div>               

                        <div class="form-group row negative-margin-top-4" id="div_dist_ubigeo"> 
                        <label class="control-label col-md-3 col-sm-3" id="lbl_dist"></label>
                        <div class="col-md-9 col-sm-9 ">
                          <input type="text" class="form-control resize-input resize-font"  id="ubigeo_distrito" autocomplete="off" onkeypress="return validateAlfaNumerico(event);">
                        </div>
                      </div>

                       
                            
                    
                    <div class="modal-footer" style="padding-bottom: 0px">
                        <button class="btn btn-success resize-button"id="save_dist"><i class="fa fa-edit"></i><span id="lbl_btn_save"></span></button>     
                    </div>
              </div>
             
             </div>
        </div>
      </div>
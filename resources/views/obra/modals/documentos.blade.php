<div id="modal-edit-documentos-obras"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  <form >
                    
                   
                  <div class="modal-header">

                          <h6 class="modal-title text-success" ><span class="badge badge-primary"><i class="fa fa-user icon-right"></i>Documentos Obras</span></h6>

                          <button type="button" class="close mr-2" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          
                    </div>
                    <div class="modal-body">
                      
                      <div class="row">

                      
                      

                      <div class="col-md-12 col-sm-12">
                      

                     
                  
                      <div class="card-box table-responsive" >

                           
                  <table id="table-obras-documentos" class="table tbl_out_margin jambo_table letra-size-tablas table-striped" style="width: 100%">
                                
                    <thead>
                    <tr>
                      <th>Documento</th>
                      <th>Fecha Modificación</th>
                      <th>Accion</th>   
                                                         
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



<div id="modal-file-upload"class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
              <div class="modal-content">

                  <div class="modal-header">
                          
                      <h6>  
                          <span class="badge badge-primary"><i class="fa fa-align-justify icon-right" ></i><span>CARGAR ARCHIVO</span></span>
                      </h6>

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                    </div>
                    <div class="modal-body">
                        <p>(*) solo se admiten archivos con extensión : <strong>jpeg , jpg , png ,pdf , docx ,xlsx</strong> y un máximo de 12 MB</p>
                        <form method="POST" action="{{url('/load_file_obra_documento')}}" class="dropzone" id="dropzoneObraDoc" enctype="multipart/form-data">
                           @csrf

                           <input type="hidden" id="IdObra_documento" name="IdObra_documento"> 

                           <input type="hidden" id="IdObraDocumento_documento" name="IdObraDocumento_documento">
                           
                           <input type="hidden" id="Valor_documento_obra" name="Valor_documento_obra">
                           
                           <input type="hidden" id="Descripcion_documento_obra" name="Descripcion_documento_obra">
                        </form>
                          
                    </div>

                    <div class="modal-footer">
                      <button class="btn btn-sm btn-success resize-button" id="btn_subir_file_cdocumento"><i class="fa fa-check mr-2"></i>Aceptar</button>
                    </div>
                   
              </div>
        </div>
</div>




<div id="ModalVerAdjuntos" class="modal fade"  data-keyboard="false" style="z-index: 99999 !important" >
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                <div class="modal-header" style="background-color: #2A3F54">
                  <h6 class="modal-title" style="color: #ffffff;" id="tituloTipoArchivo"></span>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span  aria-hidden="true">&times;</span>
                  </button></h6>
                </div>

              <div class="modal-body" >
                <div id="divPdf">
                  <iframe id="ObjPdf3" src="" width="100%" height="400" type="application/pdf"></iframe>
                </div>
                <div id="divImagen" style="height: 400px; overflow-y: scroll;">
                  <img id="imgAdjunta" src="" width="auto" height="auto">
                </div>
                
              </div>
              <div class="modal-footer modal-footer-danger">
                
                <button class="btn btn-danger btn-sm btn-round"  data-dismiss="modal" style="" >
                <i class="fa fa-close"></i>
                Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
<div id="modal-file-upload-memoria"class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <form method="POST" action="{{url('/load_file_solicitud_documento_memoria')}}" class="dropzone" id="dropzoneSolicitudDocMemoria" enctype="multipart/form-data">
                           @csrf
                          
                          <input type="hidden" name="tipo_doc_memoria" id="tipo_doc_memoria">
                        </form>
                          
                    </div>

                    <div class="modal-footer">
                      <button class="btn btn-sm btn-success resize-button" id="btn_subir_file_cdocumento_memoria"><i class="fa fa-check mr-2"></i>Aceptar</button>
                    </div>
                   
              </div>
        </div>
</div>
    <main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="page-title">Carga tu Archivo</h2>
              <p class="lead text-muted">Puede demorar unos minutos dependiendo del la informacion del archivo</p>
              <div class="row mb-4">
                <div class="col-md-12">
                  <div class="card shadow mb-4">
                    <div class="card-header">
                      <strong>Carga tu Documento</strong>
                    </div>
                    <div class="card-body">
                      <form action="/" class="dropzone bg-light rounded-lg" id="tinydash-dropzone">
                        <div class="dz-message needsclick">
                          <div class="circle circle-lg bg-primary">
                            <i class="fe fe-upload fe-24 text-white"></i>
                          </div>
                          <h5 class="text-muted mt-4">Suelte los archivos aquí o haga clic para cargarlos</h5>
                        </div>
                      </form>
                      <div id="loadingOverlay">
                        <div class="loading-content">
                          <i class="fe fe-loader fe-spin fe-48 text-white"></i>
                          <p class="text-white mt-3">Procesando empleados...</p>
                        </div>
                      </div>

                      <!-- From Uiverse.io by kennyotsu --> 
                      <div class="notifications-container mt-4" id="notificationsContainer" style="display: none;">
                        <div class="success">
                          <div class="flex">
                            <div class="flex-shrink-0">
                              
                              <svg class="succes-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                              </svg>
                            </div>
                            <div class="success-prompt-wrap">
                              <p class="success-prompt-heading">Plantilla Cargada con Exito</p>
                              <div class="success-prompt-prompt">
                                <p>Tu plantilla ha sido cargada con exito, ahora puedes enviarla para poder procesarla.</p>
                              </div>
                                
                            </div>
                          </div>
                        </div>
                      </div>

                      <button id="enviar" class="btn btn-primary mt-4" disabled>Enviar</button>
                      <button id="recetear" class="btn btn-primary mt-4">Recetear</button>
                      
                      <!-- Preview -->
                      <!-- <div class="dropzone-previews mt-3" id="file-previews"></div> -->
                      <!-- file preview template -->
                      <div class="d-none" id="uploadPreviewTemplate">
                        <div class="card mt-1 mb-0 shadow-none border">
                          <div class="p-2">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                              </div>
                              <div class="col pl-0">
                                <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                                <p class="mb-0" data-dz-size></p>
                              </div>
                              <div class="col-auto">
                                <!-- Button -->
                                <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                  <i class="dripicons-cross"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> <!-- .card-body -->
                  </div> <!-- .card -->
                </div> <!-- .col -->
              </div> <!-- .row -->
            </div>
          </div> <!-- .row -->

          <div class="col-md-12 my-4" id="errorSection" style="display: none;">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title" >La pantilla tiene Errores, Cantidad de errores (<strong id="countErrors"></strong>)</h5>
                    <p class="card-text">Soluciona los siguientes Errores y intenta cargar de nuevo</p>
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Fila</th>
                                <th>Posible Error</th>
                            </tr>
                        </thead>
                        <tbody id="errorTable">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div> <!-- .container-fluid -->
        
      </main>
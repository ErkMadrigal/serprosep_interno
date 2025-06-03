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
                      <form action="/file-upload" class="dropzone bg-light rounded-lg" id="tinydash-dropzone">
                        <div class="dz-message needsclick">
                          <div class="circle circle-lg bg-primary">
                            <i class="fe fe-upload fe-24 text-white"></i>
                          </div>
                          <h5 class="text-muted mt-4">Suelte los archivos aquí o haga clic para cargarlos</h5>
                        </div>
                      </form>
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

          <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Se encontraron 9 Errores en la plantilla</h5>
                    <p class="card-text">Soluciona los siguientes Errores y intenta cargar de nuevo</p>
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Columna</th>
                                <th>Posible Error</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3224</td>
                                <td>Keith Baird</td>
                            </tr>
                            <tr>
                                <td>3218</td>
                                <td>Graham Price</td>
                            </tr>
                            <tr>
                                <td>2651</td>
                                <td>Reuben Orr</td>
                            </tr>
                            <tr>
                                <td>2636</td>
                                <td>Akeem Holder</td>
                            </tr>
                            <tr>
                                <td>2757</td>
                                <td>Beau Barrera</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div> <!-- .container-fluid -->
        
      </main>
<main role="main" class="main-content">
  <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
              <h2 class="h3 mb-3 page-title">Empleados</h2>
              <div class="row mb-4 items-align-center">
                <div class="col-md">
                  <ul class="nav nav-pills justify-content-start">
                    <li class="nav-item">
                      <p class="nav-link active bg-transparent pr-2 pl-0 text-primary">| Cantidad Total <span class="badge badge-pill bg-primary text-white ml-2" id="total"></span></p>
                    </li>
                    <li class="nav-item">
                      <p class="nav-link text-muted px-2">| Completados <span class="badge badge-pill bg-success text-white " id="completado"></span></p>
                    </li>
                    <li class="nav-item">
                      <p class="nav-link text-muted px-2">| Pendientes <span class="badge badge-pill bg-success text-white " id="pendeintes"></span></p>
                    </li>
                    <li class="nav-item">
                      <p class="nav-link text-muted px-2">| Bajas <span class="badge badge-pill badge-danger" id="bajas"></span></p>
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                  <label for="inputLang">Registros Visibles</label>
                  <select id="inputLang" class="form-control">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>
                <div class="col-md-auto ml-auto text-right">
                  <!-- <span class="small bg-white border py-1 px-2 rounded mr-2 d-none d-lg-inline">
                    <a href="#" class="text-muted"><i class="fe fe-x mx-1"></i></a>
                    <span class="text-muted">Status : <strong>Pending</strong></span>
                  </span>
                  <span class="small bg-white border py-1 px-2 rounded mr-2 d-none d-lg-inline">
                    <a href="#" class="text-muted"><i class="fe fe-x mx-1"></i></a>
                    <span class="text-muted">April 14, 2020 - May 13, 2020</span>
                  </span> -->
                  
                  <button type="button" class="btn" data-toggle="modal" data-target=".modal-employes"><span class="fe fe-filter fe-16 text-muted"></span></button>
                  <button type="button" class="btn" id="reload"></button>
                </div>
              </div>
              <!-- Slide Modal -->
              <div class="modal fade modal-slide modal-employes" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="defaultModalLabel">Filtros</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x fe-12"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="p-2">
                        <div class="form-group my-4">
                          <p class="mb-2"><strong>Zona</strong></p>
                          <label for="multi-select2" class="sr-only"></label>
                          <select class="form-control select2-multi" id="multi-select1">
                            <optgroup label="Mountain Time Zone">
                              <option value="AZ">Arizona</option>
                              <option value="CO">Colorado</option>
                              <option value="ID">Idaho</option>
                              <option value="MT">Montana</option>
                              <option value="NE">Nebraska</option>
                              <option value="NM">New Mexico</option>
                              <option value="ND">North Dakota</option>
                              <option value="UT">Utah</option>
                              <option value="WY">Wyoming</option>
                            </optgroup>
                            <optgroup label="Central Time Zone">
                              <option value="AL">Alabama</option>
                              <option value="AR">Arkansas</option>
                              <option value="IL">Illinois</option>
                              <option value="IA">Iowa</option>
                              <option value="KS">Kansas</option>
                              <option value="KY">Kentucky</option>
                              <option value="LA">Louisiana</option>
                              <option value="MN">Minnesota</option>
                              <option value="MS">Mississippi</option>
                              <option value="MO">Missouri</option>
                              <option value="OK">Oklahoma</option>
                              <option value="SD">South Dakota</option>
                              <option value="TX">Texas</option>
                              <option value="TN">Tennessee</option>
                              <option value="WI">Wisconsin</option>
                            </optgroup>
                          </select>
                        </div> <!-- form-group -->
                        <div class="form-group my-4">
                          <p class="mb-2">
                            <strong>Estatus</strong>
                          </p>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Activos</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">Pendientes</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1-1" checked>
                            <label class="custom-control-label" for="customCheck1">Bajas</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1-2">
                            <label class="custom-control-label" for="customCheck1">Todos</label>
                          </div>
                        </div> <!-- form-group -->
                        <div class="form-group my-4">
                          <p class="mb-2"><strong>Puesto</strong></p>
                          <label for="multi-select2" class="sr-only"></label>
                          <select class="form-control select2-multi" id="multi-select2">
                            <optgroup label="Mountain Time Zone">
                              <option value="AZ">Arizona</option>
                              <option value="CO">Colorado</option>
                              <option value="ID">Idaho</option>
                              <option value="MT">Montana</option>
                              <option value="NE">Nebraska</option>
                              <option value="NM">New Mexico</option>
                              <option value="ND">North Dakota</option>
                              <option value="UT">Utah</option>
                              <option value="WY">Wyoming</option>
                            </optgroup>
                            <optgroup label="Central Time Zone">
                              <option value="AL">Alabama</option>
                              <option value="AR">Arkansas</option>
                              <option value="IL">Illinois</option>
                              <option value="IA">Iowa</option>
                              <option value="KS">Kansas</option>
                              <option value="KY">Kentucky</option>
                              <option value="LA">Louisiana</option>
                              <option value="MN">Minnesota</option>
                              <option value="MS">Mississippi</option>
                              <option value="MO">Missouri</option>
                              <option value="OK">Oklahoma</option>
                              <option value="SD">South Dakota</option>
                              <option value="TX">Texas</option>
                              <option value="TN">Tennessee</option>
                              <option value="WI">Wisconsin</option>
                            </optgroup>
                          </select>
                        </div> <!-- form-group -->
                        <div class="form-group my-4">
                          <label for="date-input1">Rango de Fechas</label>
                          <input type="text" name="datetimes" class="form-control datetimes" />

                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn mb-2 btn-primary btn-block">Apply</button>
                      <button type="button" class="btn mb-2 btn-secondary btn-block">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Buscar Empleados" id="search" aria-label="Buscar Empleados">
                <div class="input-group-append">
                  <button class="btn btn-danger" type="button" id="btnReset">
                      <i class="fe fe-trash align-self-center text-white"></i>
                  </button>
                </div>
              </div>
              <div id="loadingContainer" style="display: none;">
                <p class="mb-1"><strong>Cargando...</strong></p>
                <div class="progress mb-3">
                  <div id="progressBar" class="progress-bar" role="progressbar"
                      style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                  </div>
                </div>
              </div>
              <table class="table table-hover bg-white">
                <thead>
                  <tr role="row">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>CRUP</th>
                    <th>Ingreso</th>
                    <th>Puesto</th>
                    <th>Zona</th>
                    <th>activo</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="dataTable">
                </tbody>
              </table>
              <nav aria-label="Table Paging" class="my-3">
                <ul class="pagination justify-content-end mb-0">
                </ul>
              </nav>
            </div>
          </div> <!-- .row -->
        </div> <!-- .container-fluid --><!-- .container-fluid -->
  
</main
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Nuevo empleado</h2>
                <p class="text-muted"></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <!--     <strong class="card-title">Advanced invalidation</strong>  -->
                            </div>
                            <div class="card-body">
                                <form class="needs-invalidation" id="formulario" noinvalidate>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Nombre (s) <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="nombre" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Apellido Paterno <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="paterno" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Apellido Materno <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="materno" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">CURP <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="curp" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">RFC <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="rfc" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">NSS <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="nss" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Alergias <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="alergias" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="Codigo postal">Codigo Postal Fiscal<strong
                                                    class="text-danger">*</strong></label>
                                            <input class="form-control input-code" type="text" id="cp"
                                                autocomplete="off" maxlength="6" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Empresa <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="empresa" required>
                                                <option selected disabled value="">Seleccione una empresa</option>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Unidad de negocio <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="unidadNegocio" required>
                                                <option selected disabled value="">Seleccione una Unidad de negocio
                                                </option>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Gerente Regional <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="regional" required>
                                                <option selected disabled value="">Seleccione un Gerente Regional
                                                </option>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido</div>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Zona / Área </label>
                                            <select class="form-control select2" id="zona">
                                                <option selected disabled>Seleccione una Zona / Área</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Servicio </label>
                                            <input class="form-control" type="text" id="servicio" list="servicios">
                                            <input type="hidden" id="servicioId">
                                            <datalist id="servicios"></datalist>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Turno <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="turno">
                                                <option selected disabled value="">Seleccione un Turno</option>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Puesto <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="puesto">
                                                <option selected disabled value="">Seleccione un Puesto</option>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido</div>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Periocidad <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="periocidad">
                                                <option selected disabled value="">Seleccione un Periocidad</option>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Sueldo <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="number" class="form-control" id="sueldo" required>
                                            <div class="invalid-feedback"> El campo es requerido</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">No. Cuenta</label>
                                            <input type="text" class="form-control" id="cuenta">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">No. Clave Interbancaria <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="interbancaria"
                                                autocomplete="off" maxlength="23" placeholder="____-____-____-____-__"
                                                required>
                                            <div class="invalid-feedback"> El campo es requerido</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="Bancaria">Institución Bancaria <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="institucionBancaria" required
                                                disabled>
                                            <input type="hidden" class="form-control" id="banco" required disabled>
                                            <div class="invalid-feedback"> El campo es requerido</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" id="add">Agregar</button>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- end section -->
            </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>
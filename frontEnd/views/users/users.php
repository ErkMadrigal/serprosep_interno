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
                                            <label for="invalidationCustom3">Correo <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="correo" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
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
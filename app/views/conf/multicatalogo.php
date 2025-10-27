<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Multicatalogo</h2>
                <p class="text-muted"></p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                    <strong class="card-title">Tipo Catalogo</strong> 
                            </div>
                            <div class="card-body">
                                <form class="needs-invalidation-catalogo" noinvalidate>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="invalidationCustom3">Tipo de Catalogo<strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="descripcion" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" id="add_catalogo">Agregar Catalogo</button>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Detalles Catalogo</strong> 
                            </div>
                            <div class="card-body">
                                <form class="needs-invalidation" noinvalidate>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Catalogo<strong
                                                class="text-danger">*</strong></label>
                                                <select class="form-control catalogosSelect" id="id_Catalogo" name="id_Catalogo" required>
                                                    <option value="">Selecciona una Opcion</option>
                                                </select>
                                                <div class="invalid-feedback"> El campo es requerido </div>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Valor <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="valor" required>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Descripcion</label>
                                            <input type="text" class="form-control" id="descripcion">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" id="add">Agregar</button>
                                </form>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->

                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong class="card-title">Todos los catalogos</strong> 
                            </div>
                            <div class="card-body">
                                <form class="needs-invalidation-search" noinvalidate>
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label for="invalidationCustom3">Catalogos<strong
                                            class="text-danger">*</strong></label>
                                            <select class="form-control catalogosSelect" id="id_Catalogo_Search" name="id_Catalogo_Search" >
                                                <option value="">Selecciona una Opcion</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <form class="form">
                                    <div class="form-group col-auto">
                                        <label for="search" class="sr-only">Search</label>
                                        <input type="text" class="form-control" id="searchTable" value="" placeholder="Buscar...">
                                    </div>
                                </form>
                                <table class="table table-borderless table-hover">
                                    <thead>
                                    <tr>
                                        <th>Valor</th>
                                        <th>Descripcion</th>
                                        <th>Catalogo</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableCatalogos">
                                        
                                    </tbody>
                                </table>
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- end section -->
            </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main>
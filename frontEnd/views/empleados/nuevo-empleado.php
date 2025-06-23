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
                                <form class="needs-invalidation" noinvalidate>
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
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Unidad de negocio <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="unidadNegocio" required>
                                            </select>
                                            <div class="invalid-feedback"> El campo es requerido </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Gerente Regional </label>
                                            <input type="text" class="form-control" id="regional">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Zona/ Área </label>
                                            <select class="form-control select2" id="zona">
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Servicio </label>
                                            <input class="form-control" type="text" id="servicio" list="servicios">
                                            <input type="hidden" id="servicioId">
                                            <datalist id="servicios"></datalist>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom4">Turno </label>
                                            <select class="form-control select2" id="turno">
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Puesto <strong
                                                    class="text-danger">*</strong></label>
                                            <select class="form-control select2" id="puesto">
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Sueldo <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="number" class="form-control" id="sueldo" required>
                                            <div class="invalid-feedback"> El campo es requerido</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="invalidationCustom3">Periocidad <strong
                                                    class="text-danger">*</strong></label>
                                            <input type="text" class="form-control" id="periocidad" required>
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
                                    <!-- /.form-row 
                  <div class="form-row">
                    <div class="col-md-8 mb-3">
                      <label for="exampleInputEmail2">Email address</label>
                      <input type="email" name class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp1" required>
                      <div class="ininvalid-feedback"> Please use a invalid email </div>
                      <small id="emailHelp1" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="custom-phone">US Telephone</label>
                      <input class="form-control input-phoneus" id="custom-phone" maxlength="14" required>
                      <div class="ininvalid-feedback"> Please enter a correct phone </div>
                    </div>
                  </div> 
                  <div class="form-group mb-3">
                    <label for="address-wpalaceholder">Address</label>
                    <input type="text" id="address-wpalaceholder" class="form-control" placeholder="Enter your address">
                    <div class="invalid-feedback"> Looks good! </div>
                    <div class="ininvalid-feedback"> Badd address </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label for="invalidationCustom33">City</label>
                      <input type="text" class="form-control" id="invalidationCustom33" required>
                      <div class="ininvalid-feedback"> Please provide a invalid city. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="invalidationSelect2">State</label>
                      <select class="form-control select2" id="invalidationSelect2" required>
                        <option value="">Select state</option>
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
                      <div class="ininvalid-feedback"> Please select a invalid state. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="custom-zip">C.P.</label>
                      <input class="form-control input-zip" id="cp" autocomplete="off" maxlength="9" required>
                      <div class="ininvalid-feedback"> Please provide a invalid zip. </div>
                    </div>
                  </div>
                  <div class="form-row mb-3">
                    <div class="col-md-6 mb-3">
                      <label for="date-input1">Date Picker</label>
                      <div class="input-group">
                        <input type="text" class="form-control drgpicker" id="date-input1" value="04/24/2020" aria-describedby="button-addon2">
                        <div class="input-group-append">
                          <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="example-time">Time</label>
                      <input class="form-control" id="example-time" type="time" name="time" required>
                    </div>
                    <div class="col-md-3 mx-auto mb-3">
                      <p class="mb-3">Pick Up</p>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" required>
                        <label class="custom-control-label" for="customSwitch1">Yes</label>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <p class="mb-2">Payment</p>
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="customControlinvalidation22" name="radio-stacked" required>
                          <label class="custom-control-label" for="customControlinvalidation22">Card</label>
                          <p class="text-muted"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="custom-control custom-radio mb-3">
                          <input type="radio" class="custom-control-input" id="customControlinvalidation33" name="radio-stacked" required>
                          <label class="custom-control-label" for="customControlinvalidation33">Paypal</label>
                          <p class="text-muted"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="invalidationTextarea1">Note</label>
                    <textarea class="form-control" id="invalidationTextarea1" placeholder="Take a note here" required="" rows="3"></textarea>
                    <div class="ininvalid-feedback"> Please enter a message in the textarea. </div>
                  </div>
                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="customControlinvalidation16" required="">
                    <label class="custom-control-label" for="customControlinvalidation16"> Agree to terms and conditions</label>
                    <div class="ininvalid-feedback"> You must agree before submitting. </div>
                  </div>-->
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
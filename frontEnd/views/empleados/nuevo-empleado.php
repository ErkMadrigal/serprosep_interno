<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="page-title">Form validation</h2>
        <p class="text-muted">Provide valuable, actionable feedback to your users with HTML5 form validation</p>
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <strong class="card-title">Advanced Validation</strong>
              </div>
              <div class="card-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom3">First name</label>
                      <input type="text" class="form-control" id="validationCustom3" value="Mark" required>
                      <div class="valid-feedback"> Looks good! </div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom4">Last name</label>
                      <input type="text" class="form-control" id="validationCustom4" value="Otto" required>
                      <div class="valid-feedback"> Looks good! </div>
                    </div>
                  </div> <!-- /.form-row -->
                  <div class="form-row">
                    <div class="col-md-8 mb-3">
                      <label for="exampleInputEmail2">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp1" required>
                      <div class="invalid-feedback"> Please use a valid email </div>
                      <small id="emailHelp1" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="custom-phone">US Telephone</label>
                      <input class="form-control input-phoneus" id="custom-phone" maxlength="14" required>
                      <div class="invalid-feedback"> Please enter a correct phone </div>
                    </div>
                  </div> <!-- /.form-row -->
                  <div class="form-group mb-3">
                    <label for="address-wpalaceholder">Address</label>
                    <input type="text" id="address-wpalaceholder" class="form-control" placeholder="Enter your address">
                    <div class="valid-feedback"> Looks good! </div>
                    <div class="invalid-feedback"> Badd address </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6 mb-3">
                      <label for="validationCustom33">City</label>
                      <input type="text" class="form-control" id="validationCustom33" required>
                      <div class="invalid-feedback"> Please provide a valid city. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="validationSelect2">State</label>
                      <select class="form-control select2" id="validationSelect2" required>
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
                      <div class="invalid-feedback"> Please select a valid state. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                      <label for="custom-zip">Zip code</label>
                      <input class="form-control input-zip" id="custom-zip" autocomplete="off" maxlength="9" required>
                      <div class="invalid-feedback"> Please provide a valid zip. </div>
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
                          <input type="radio" class="custom-control-input" id="customControlValidation22" name="radio-stacked" required>
                          <label class="custom-control-label" for="customControlValidation22">Card</label>
                          <p class="text-muted"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="custom-control custom-radio mb-3">
                          <input type="radio" class="custom-control-input" id="customControlValidation33" name="radio-stacked" required>
                          <label class="custom-control-label" for="customControlValidation33">Paypal</label>
                          <p class="text-muted"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="validationTextarea1">Note</label>
                    <textarea class="form-control" id="validationTextarea1" placeholder="Take a note here" required="" rows="3"></textarea>
                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                  </div>
                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="customControlValidation16" required="">
                    <label class="custom-control-label" for="customControlValidation16"> Agree to terms and conditions</label>
                    <div class="invalid-feedback"> You must agree before submitting. </div>
                  </div>
                  <button class="btn btn-primary" type="submit">Submit form</button>
                </form>
              </div> <!-- /.card-body -->
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div> <!-- end section -->
      </div> <!-- /.col-12 col-lg-10 col-xl-10 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
</main>
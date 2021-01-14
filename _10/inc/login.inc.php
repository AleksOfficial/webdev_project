<div class="container">
<form class="w-100" action="index.php" method="POST">
  <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" name="username" class="form-control" id="username" placeholder="username"
          required>
  </div>
  <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="password"
          required>
  </div>
  <div class="row">
      <div class="col-md-6">
          <div class="form-check">
              <input class="form-check-input" type="checkbox" value="true" id="keep_logged_in" name="keep_logged_in">
              <label class="form-check-label" for="keep_logged_in">
                  Keep me logged in
              </label>
          </div>
      </div>
  </div>
  <button type="submit" name ="login_button" class="btn-secondary btn btn-custom btn-lg btn-block mt-3 float-right ">Login Now</button>
  </form>
  <form action ="index.php" method = "GET">
  <button type="submit" name ="register" class="btn-secondary btn btn-custom btn-lg btn-block mt-3 float-right ">Register Now</button>
  <button type="submit" name ="password_reset" class="btn-secondary btn btn-custom btn-lg btn-block mt-3 float-right ">Forgot password</button>
</form>
</div>
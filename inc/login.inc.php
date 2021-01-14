<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Sign In</h3>
				<div class="d-flex justify-content-end social_icon">
          <a href="index.php">
					<span><i class="fab fa-text">Go back ...</i>
            <i class="fab fa-logo"><img src="res/icons/logo.png"></i></span></a>
				</div>
			</div>
			<div class="card-body">
				<form>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"><img src="res/icons/user.png"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"><img src="res/icons/lock.png"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="password">
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox" name ="logged" >Remember Me
					</div>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a href="index.php?register=">Sign Up</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="./sites/reset-pw.php">Forgot your password?</a>
				</div>
			</div>
		</div>
	</div>
</div>
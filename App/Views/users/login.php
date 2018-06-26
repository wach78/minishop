
<?php require_once(VIEWINCLUDE. 'header.php');?>



<?php require_once(VIEWINCLUDE. 'navbar.php');?>



<div class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Login</h2>
			
			<form action="<?php echo URLROOT;?>/users/login" method="post">
				
				<div class="form-group">
				<label for="email">Email: <sub>*</sub></label>
				<input type="email" name="email" id="email" class="form-control form-control-lg  <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ;?>" value="<?php echo $data['email'];?>">
				<span class="invalid-feedback"><?php echo $data['email_err']?></span>
				</div>
				
				<div class="form-group">
				<label for="pass">Password: <sub>*</sub></label>
				<div class="input-group mb-3">
				<input type="password" name="password" id="pass" class="form-control form-control-lg  <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '' ;?>" value="<?php echo $data['password'];?>">
				
				<div class="input-group-append">
                <button class="btn btn-outline-secondary toggleshow" type="button"><span style='text-align:center;'><i id="eye" class="fa fa-eye" title="Visa" aria-hidden="true"></i></span></button>
                </div>
                </div>	
                
				<span class="invalid-feedback"><?php echo $data['password_err']?></span>
				</div>

				<div class="row">
					<div class="col">
					<input type="submit" value="login" class="btn btn-success btn-block">
					</div>
				</div> 
			</form>
		</div>
	</div>
</div>





<?php require_once(VIEWINCLUDE. 'footer.php'); ?>




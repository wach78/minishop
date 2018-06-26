<?php 
use Simpleframework\Helpers\Util;
use Simpleframework\Middleware\Csrf;

?>

<?php require_once(VIEWINCLUDE. 'header.php');?>



<?php require_once(VIEWINCLUDE. 'navbar.php');?>


<div class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Lägg till produkt</h2>
			<?php Util::flash('addpro');?>
			<form action="<?php echo URLROOT;?>/admin/addproduct" method="post">
				<?php echo CSRF::csrfTokenTag();?>
				<div class="form-group">
				<label for="Name">Namn <sub>*</sub></label>
				<input type="text" name="Name" id="Name" class="form-control form-control-lg  <?php echo (!empty($data['Name_err'])) ? 'is-invalid' : '' ;?>" value="<?php echo $data['Name'];?>">
				<span class="invalid-feedback"><?php echo $data['Name_err']?></span>
				</div>
				
				<div class="form-group">
				<label for="Productumber">Produktnummer </label>
				<input type="text" name="Productumber" id="Productumber" class="form-control form-control-lg  <?php echo (!empty($data['Productumber_err'])) ? 'is-invalid' : '' ;?>" value="<?php echo $data['Productumber'];?>">
				<span class="invalid-feedback"><?php echo $data['Productumber_err']?></span>
				</div>
				
				<div class="form-group">
				<label for="Price">Pris <sub>*</sub></label>
				<input type="text" name="Price" id="Price" class="form-control form-control-lg  <?php echo (!empty($data['Price_err'])) ? 'is-invalid' : '' ;?>" value="<?php echo $data['Price'];?>">
				<span class="invalid-feedback"><?php echo $data['Price_err']?></span>
				</div>
				
				
				<div class="form-group">
				<label for="Stock">Antal i lager</label>
				<input type="text" name="Stock" id="Stock" class="form-control form-control-lg  <?php echo (!empty($data['Stock_err'])) ? 'is-invalid' : '' ;?>" value="<?php echo $data['Stock'];?>">
				<span class="invalid-feedback"><?php echo $data['Stock_err']?></span>
				</div>
				
				<div class="form-group">
				<label for="Description">Beskrivning </label>
				<textarea name="Description" id="Description" class="form-control form-control-lg <?php echo (!empty($data['Description_err'])) ? 'is-invalid' : '' ;?>"><?php echo $data['Description'];?> </textarea>
				<span class="invalid-feedback"><?php echo $data['Description_err']?></span>
				</div>

				<div class="row">
					<div class="col">
					<input type="submit" value="Lägg till" class="btn btn-success btn-block">
					</div>
				</div> 
				
				
			</form>
			


		</div>
	</div>
</div>




<?php require_once(VIEWINCLUDE. 'footer.php'); ?>
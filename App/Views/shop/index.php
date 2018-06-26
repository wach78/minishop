<?php
use Simpleframework\Middleware\Csrf;

?>

<?php require_once(VIEWINCLUDE. 'header.php');?>



<?php require_once(VIEWINCLUDE. 'navbar.php');?>

<div class="row">
	<div class="col-md-10 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Dessa produkter finns</h2>
			
		
		
		<?php 
		
		$productdata = $data['tabledata'];
		$rowlen = count($productdata);
		
	
		
		$j = 0;
		for ($i = 0; $i < $rowlen; $i++)
		{
		    if ($i % 3 == 0)
		    {
		        ?>
		        <div class="row">
		        <div class="col-md-3">
		        <div class="card">
  				<div class="card-header"><?php echo $productdata[$i]->Name;?></div>
  				<div class="card-body">
  				<p>Pris: <?php echo $productdata[$i]->Price;?> </p>
  				<p>Produkt nummer: <?php echo $productdata[$i]->Productumber;?> </p>
  				<p>Antal i lager: <?php echo $productdata[$i]->Stock;?></p>
  				<p>Beskrivning: <?php echo $productdata[$i]->Description;?> </p>
  				</div> 
  				<div class="card-footer">
  				<form class="frmaddtocart" method="post">
				<?php echo Csrf::csrfTokenTag();?>
				<input type="hidden" name="PID" value="<?php echo $productdata[$i]->ID;?>">
  				<input type="submit" value="Lägg i kundvagn" class="btn btn-success btn-block btnaddproduct">
  				
  				</form>
  				</div>
				</div>
                  
		        
		        </div>
		        <?php 
		        $j++;
		    }
		    else 
		    {
		       ?>
		        <div class="col-md-3">
		        <div class="card">
  				<div class="card-header"><?php echo $productdata[$i]->Name;?></div>
  				<div class="card-body">
  				<p>Pris: <?php echo $productdata[$i]->Price;?> </p>
  				<p>Produkt nummer: <?php echo $productdata[$i]->Productumber;?> </p>
  				<p>Antal i lager: <?php echo $productdata[$i]->Stock;?></p>
  				<p>Beskrivning: <?php echo $productdata[$i]->Description;?> </p>
  				</div> 
  				<div class="card-footer">
  				<form class="frmaddtocart" method="post">
				<?php echo Csrf::csrfTokenTag();?>
				<input type="hidden" name="PID" value="<?php echo $productdata[$i]->ID;?>">  
  				<input type="submit" value="Lägg i kundvagn" class="btn btn-success btn-block btnaddproduct">
  				
  				</form>
  				</div>
		        
		        
		        </div>
		        </div>
		        <?php
		        $j++;
		    }
		   
		    
		    if ($j == 3)
		    {
		        
		        echo '</div>';
		        $j = 0;
		    }
		    
		}
		
		
		
		
		?>
		
		

		
		</div>
			
			
		</div>
	</div>
</div>



<!-- The Modal -->
<div class="modal" id="shoppingCartModal">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Kundvagn</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="row mb-2" id="firstrow">
      <div class="col">
      <b>Product</b>
      </div>
        <div class="col">
      <b>Produktnummer</b>
      </div>    
       <div class="col">
      <b>Pris</b>
      </div>  
      <div class="col">
      <b>Antal</b>
      </div>
      <div class="col">
      <b>Summa</b>
      </div>

      </div>
	</div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <p><b>Total summa: </b></p><p id="totsum" ><p>
      </div>

    </div>
  </div>
</div>






<?php require_once(VIEWINCLUDE. 'footer.php'); ?>
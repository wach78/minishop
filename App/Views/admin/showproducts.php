
<?php use Simpleframework\Middleware\Csrf;
use Simpleframework\Middleware\Sanitize;

require_once(VIEWINCLUDE. 'header.php');?>



<?php require_once(VIEWINCLUDE. 'navbar.php');?>

<div class="row">
	<div class="col-md-12 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Visa alla produkter</h2>
			
			
			<div class="row">
				<div class="col-md-10 mx-auto">
        			<div class="table-responsive">
        			
        			<table class="table table-bordered table-hover table-striped" id="tblproducts">
        			<thead>
        			<tr>
        			<th class="tacenter"><a href="<?php echo URLROOT;?>/Admin/addproduct" class="btn"><i class="fa fa-plus fa-1x text-success"></i></a> </th>
        			
        			<th>Namn</th>
        			<th>Produktnummer</th>
        			<th>Pris</th>
        			<th>Antal i lager</th>
        			<th>Beskrivning</th>
        			</tr>
        			</thead>
        			<?php 
        			$tabledata = $data['tabledata'];
        			$rowlen = count($tabledata);
        			$collen = count($data['datacolumns']);
        			?>
        			
        			<tbody>
        			<?php 
        			for ($i = 0; $i < $rowlen; $i++)
        			{
        			    echo '<tr>';
        			    
        			    for ($j = 0; $j < $collen; $j++)
        			    {
        			        $col = $data['datacolumns'][$j];
        			        
        			        if ($col == 'ID')
        			        {
        			            ?>
        			            <td>
        			            <form method="POST" id="frmUpdateDelete">
        			            <?php echo Csrf::csrfTokenTag();?>
        			            <button type="submit" formaction="<?php echo URLROOT;?>/admin/editproduct/<?php echo Sanitize::cleanOutput($tabledata[$i]->$col);?>" class="btn float-left transparent"> <i class="fa fa-user-edit text-warning fa-1x "></i></button>
        			            <button type="submit" formaction="<?php echo URLROOT;?>/admin/deleteproduct/<?php echo Sanitize::cleanOutput($tabledata[$i]->$col);?>" class="btn float-right transparent delbtn"> <i class="fa fa-trash fa-1x text-danger"></i></button>
        			            </form>
        		            	</td>
        			            <?php
        			        }
        			        else
        			        {
        			            echo '<td>';
        			            echo  Sanitize::cleanOutput($tabledata[$i]->$col);
        			            echo '</td>';
        			        }
        			    }
        			    
        			    
        			    
        			    echo '</tr>';
        			}
        			
        			?>
        			
        			</tdody>
        			
        			</table>
        			
        			</div>
				</div>
			</div>
        			
			
			
		</div>
	</div>
</div>






<?php require_once(VIEWINCLUDE. 'footer.php'); ?>
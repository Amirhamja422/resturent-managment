<?php 
session_start();
include_once "../libs/database.php";
if (isset($_POST['id'])) 
{
	$product_id=$_POST['id'];
	$sql=mysql_query("SELECT * FROM `product` WHERE `id`='$product_id'");
	$row=mysql_fetch_assoc($sql);
	?>
	<div class="modelImg">
		<img class="model_img" src="../../madchef-admin/productimage/<?php echo $row['image']; ?>"/>
	</div>
	<div class="modal-body">
		<div class="col-md-12">
			<div class="col-md-9 float-left">
				<p class="h3"><?php echo $row['name']; ?></p>
				<p><?php echo $row['deatails']; ?></p>
				<input type="text" name="product_id" id="product_id" hidden value="<?php echo $row['id']; ?>" >
				<input type="text" name="product_vat" id="product_vat" hidden value="<?php echo $row['vat']; ?>">
				<input type="text" name="product_sd" id="product_sd" hidden value="<?php echo $row['sd']; ?>">
			</div>
			<div class="col-md-3 float-left">
				<p class="h5">Tk = <?php echo $row['price']; ?></p>
			</div>
		</div> 
		<div class="col-md-12">
			
			<?php 
			$extra_item= $row['subcategory'];
			if($extra_item !=null){
			($explode_extra_item=explode(",",$extra_item));
			}
			$extra_item_len=count($explode_extra_item);
			foreach ($explode_extra_item as $value) 
			{
				?>
				<div class="col-md-12">
					<h6><?php echo $value; ?><span class="text-danger text-bold">*</span></h6>
					<div class="left" style="float:left; margin-left: 30px;">
						<?php 
						$brand=$row['brand'];
						$branch=$row['branch'];
						$sql_sp=mysql_query("SELECT * FROM `su_product` WHERE `brand`='$brand' AND `branch`='$branch' AND `category`='$value'");
						while ($row_sp=mysql_fetch_assoc($sql_sp)) 
						{
							// echo $row_sp['name'];
							?>

							<div class="radio" id="sub_product">
								<label><input class="m-2" value="<?php echo $row_sp['id'];?>" type="radio" id="sub_product_id" name="<?php echo $value;?>" ><?php echo $row_sp['name']; ?></label><br>

							</div>


							<?php
						}

						?>
					</div>
				</div>
				<?php
			}
			?>
			<div class="col-md-12">
			<?php  
				$sql_adons_result=mysql_query("SELECT `adons_status` FROM `product` WHERE `id`='$product_id'");
				$row_adons=mysql_fetch_assoc($sql_adons_result);
				$count_adons=mysql_num_rows($sql_adons_result);
				if($row_adons['adons_status']!=null)
				{
					?>
					<h6>Add On's</h6>
					<div class="">
						<table style="width: 100%; margin-left: 30px;">
					<?php
					$adons_id_arr= (explode(",",$row_adons['adons_status']));
					foreach ($adons_id_arr as $value) {
						$select_adons_product=mysql_query("SELECT * FROM `adons_product` WHERE `id`='$value'");
						$row_adons_product=mysql_fetch_assoc($select_adons_product);
						?>
							<tr>
								<td>

									<input type="checkbox" value="<?php echo $row_adons_product['price'].".".$row_adons_product['id']; ?>" id="<?php echo $row_adons_product['id']; ?>" name="add_ons" onclick="adons_product('<?php echo  $row['price']; ?>')"  />										
									<label> <?php echo $row_adons_product['name']; ?></label>
								</td>
								<td class="float-right mr-5"><p>Tk <?php echo $row_adons_product['price']; ?></p></td>
							</tr>
						<?php
					
					}
					?>
						</table>
						</div>
					<?php
				}
				
				
			?>
			</div>
				<div class="col-md-12">
						<hr>
					</div>
				<div class="col-md-12">
					<p  class="float-right" style="margin-right: 0px;"> Total Tk = <span id="total_product_price"><?php echo $row['price']; ?></span></p>
				</div>
				<!-- <div class="col-md-12" style="visibility: hidden; height: 0px; overflow: hidden;"> -->
				<div class="col-md-12">
					<p class="h3">Special instructions</p>
					<p>Any specific preferences? Let the restaurant know.</p>
					<div class="form-group">
						<textarea class="form-control" id="extra_instruction" rows="3" placeholder="Notes"></textarea>
					</div>
				</div>
				<!-- <div class="col-md-12" style="visibility: hidden; height: 0px; overflow: hidden;"> -->
				<div class="col-md-12">
					<p class="h3">If this product is not available</p>
					<div class="form-group">
						<select class="form-control" id="product_not_available">
							<option value="Remove it from my order">Remove it from my order</option>
							<option value="Cancel whole order">Cancel whole order</option>
							<option value="Call me">Call me</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-12">
			<span id="alert_message" class="text-danger"></span>
			</div>
			<div class="col-md-12 shadow p-3 mb-5 bg-white rounded">
				<div class="col-md-2 mt-2 float-left">
					<!-- <p class="h5"><span class="p-1">-</span> <span class="p-1">6</span> <span class="p-1">+</span></p> -->
					
								
					<div class="form-group">
					<button onclick="decrement('<?php echo $row['price']; ?>')" class="float-left text-white btn btn-danger btn-sm">-</button>
					<input readonly style="width: 35px;" class="from-control m-1 text-center" id="quantity" value="1"   type="number" min=1 max=1100>	
					<button onclick="increment('<?php echo $row['price']; ?>')" class="float-right text-white btn btn-danger btn-sm"><span>+</span></button>
 					</div>
					
				</div>
				
				<div class="col-md-10 float-left">
					<div class="col-md-12">
						
						<button type="button" onclick="add_to_cart('<?php echo $row['name'];?>', <?php echo $row['price']; ?>,'<?php echo $extra_item_len; ?>' )" class="btn btn-danger btn-lg btn-block">Add To Cart</button>
					</div>
				</div>
			</div>
		</div>
	</div> 

	<?php
}
?>

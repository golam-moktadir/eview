<label for="sub_category">Select Sub Category</label>
<?php 
  foreach($sub_categories as $sub_category){
?>
<input type="checkbox" value="<?php echo $sub_category->record_id ?>" name='sub_category[]'> <?php echo $sub_category->sub_category ?><br>
<?php } ?>

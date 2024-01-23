<?php
  global $wpdb;
  global $table_prefix;
  $table = $table_prefix.'sachin_plugin';
  if($_POST && $_POST['name']){
    if($_POST['id']=='0'){
      if($wpdb->insert($table,["name"=>$_POST['name']])){
        $msg = '<span class="true">Successfully Added</span>';
      }else{
        $msg = '<span class="false">Add : Error</span>'; 
      }
    }else{
      if($wpdb->query("UPDATE $table SET `name` = '".$_POST['name']."' WHERE `id` = ".$_POST['id']."")){
        $msg = '<span class="true">Successfully Updated</span>';
      }else{
        $msg = '<span class="false">Update : Error</span>'; 
      }
    }
    
    // $sql_insert = $wpdb->query("UPDATE $table SET `name` = '".$_POST['name']."' WHERE `id` = ".$_POST['id']."");
    // $result=$wpdb->get_results($sql_insert); 
  }
?>
<!DOCTYPE html>
<html>
<head>
<?php wp_head(); ?>
</head>
<body>
<div class="container" id="main_div"> 
<h3 style="text-align:center">Sachin Plugin Page</h3>
<?php
	$sql = "Select * from $table";
	$result=$wpdb->get_results($sql); 
?>
<div style="text-align:center">
    <span style="float:left" id="result_msg"><?php echo '' ;?></span>
    <span style="float:right">
      <button id="delete" class="btn btn-danger">Delete</button>
      <button id="add" class="btn btn-success add_sachin">Add New</button>
    </span>
    <!-- <span>Center Text</span> -->
</div>
	<table id="customers">
		<tr>
			<th>S.No</th>
			<th>Name</th>
			<th>Action</th>
		</tr>
		<?php
		$count = 1 ;
	foreach ($result as $list) {?>

		<tr id="row_<?php echo $list->id; ?>">
			<td><input type="checkbox" name="s_id" value="<?php echo $list->id; ?>" id="checkbox_id"><?php echo $count; ?></td>
			<td><?php echo $list->name; ?></td>
			<td><button id="edit" class="btn btn-success edit_sachin" data-id="<?php echo $list->id; ?>">Edit</button></td>
		</tr>

	<?php $count++;} ?>

	</table><br>

  <!-- The Modal -->
  <div class="modal fade" id="empModal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Modal Heading</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          Modal body..
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        	<button type="submit" style="margin-right: auto;width: 290px;" class="btn btn-success" value="Submit" onclick="form_submit()">Submit</button>
        	<button type="submit" style="margin-right: auto;" class="btn btn-warning" value="Reset" onclick="form_reset()">Reset</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
</div>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
#main_div{
  width: 75%;
  padding-top: 2%;
}
  .true{
    color: green;
  }
  .false{
    color: red;
  }
  #result_msg{
  	font-size: 16px;
  }
  #edit{
    padding: revert;
  }
</style>
<script type="text/javascript">
jQuery(function () {
    jQuery("#delete").click(function () {
    	var val = [];
        jQuery(':checkbox:checked').each(function(i){
          val[i] = jQuery(this).val();
        });
        if(val.length===0){
        	alert('You didn`t select any data !');
        }else{
        	if (window.confirm("Are you sure you want to Delete?")) {
	      	  var link = "<?php echo admin_url('admin-ajax.php');?>";
		      jQuery.ajax({
		        url:link,
		        type:'GET',
		        processData:false,
		        contentType:false,
		        data: "action=sachin_plugin_delete_btn&s_id="+val,
		        success:function(result){
			        for (i = 0; i < val.length; i++) {
    					  jQuery('#row_'+val[i]).hide();
    					}	
		          jQuery('#result_msg').html('<span class="'+result.success+'">'+result.data+'</span>');
		          
	        		// alert(JSON.stringify(result));
		        }
		      })
	  		}
        }
    });
    jQuery(".edit_sachin").click(function () {
    	var edit_id = jQuery(this).data("id");
	    var link = "<?php echo admin_url('admin-ajax.php');?>";
	    var data = {'action': 'sachin_plugin_edit_btn',
				    'e_id': edit_id};
		jQuery.post(link, data, function(response) {
			// alert(JSON.stringify(response));
		    // console.log( response );
		    jQuery('.modal-body').html(response.data);

	      	// Display Modal
	      	jQuery('#empModal').modal('show'); 
		  }, 'json');
    });

    jQuery(".add_sachin").click(function () {
      var link = "<?php echo admin_url('admin-ajax.php');?>";
      var data = {'action': 'crawler_info',_wpnonce : my_var.nonce,};
      var formdata = new FormData();
      formdata.append('action', 'sachin_plugin_add_btn');
      jQuery.ajax( {
        method : 'POST',
        dataType : 'json',
        url : my_var.ajaxurl,
        data : {
          foo : 'foobar',
          _wpnonce : my_var.nonce,
          action : 'my_php_ajax_function'
        }
      } )
      .done(
        function( data ){
          console.log(data);				
        }
      );
      // jQuery.get({
      //   url : '/wordpress/wp-admin/admin-ajax.php',
      //   data : data,
      //   processData : false,
      //   contentType : false,
      //   // type: 'post',
      //   success : function(response){
      //     console.log(response);
      //   },
      //   error : function(response){
      //     console.log(response);
      //   }
      // })
      // formData.append('action', 'sachin_plugin_add_btn');
    // jQuery.post(link, data, function(response) {
    //   // alert(JSON.stringify(response));
    //     // console.log( response );
    //     jQuery('.modal-body').html(response.data);

    //       // Display Modal
    //       jQuery('#empModal').modal('show'); 
    //   }, 'json');
    });
});

function form_submit() {
  var name = jQuery("#name").val();
  if(name === ''){
    alert('You didn`t select any data !');
  }else{
    document.getElementById("search_form").submit();
  }
} 
function form_reset() {
  jQuery("input:text").val("");
}
setTimeout(function() {
    jQuery('.true , .false').fadeOut('slow');
}, 5000);
</script>
</body>
</html>

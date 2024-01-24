<!-- <button id="emp_form">click</button> -->
<form action="<?php echo admin_url('admin.php');?>" id="emp_form" data-employee-id="<?php echo $data['e_id']; ?>">
    <input type="hidden" name="page" value="my-submenu-handle">
    <input type="hidden" name="e_id" value="<?php echo $data['e_id']; ?>">
    <input type="text" name="first_name" value="<?php echo $data['first_name']; ?>" ><br>
    <input type="text" name="last_name" value="<?php echo $data['last_name']; ?>" ><br>
    <input type="radio" id="active" name="status" value="active" <?php echo ($data['status'] == '1') ? 'checked' : ''  ?> >
    <label for="active">active</label><br>
    <input type="radio" id="inactive" name="status" value="inactive" <?php echo ($data['status'] == '0') ? 'checked' : ''  ?> >
    <label for="inactive">Inactive</label><br>
    <input type="submit" value="save">
</form>
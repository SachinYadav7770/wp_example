<form action="<?php echo admin_url('admin.php');?>" id="emp_form" data-employee-id="">
    <input type="hidden" name="page" value="my-submenu-handle">
    <input type="text" name="first_name"><br>
    <input type="text" name="last_name"><br>
    <input type="radio" id="active" name="status" value="active">
    <label for="active">active</label><br>
    <input type="radio" id="inactive" name="status" value="inactive">
    <label for="inactive">Inactive</label><br>
    <input type="submit" value="search">
</form>
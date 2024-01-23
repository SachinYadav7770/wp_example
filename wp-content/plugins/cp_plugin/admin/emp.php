<div class="wrap">
    <h2>HTML Table</h2>
    <form action="<?php echo admin_url('admin.php');?>" id="cp_sub_page_search_form">
        <input type="hidden" name="page" value="my-submenu-handle">
        <input type="text" name="search" id="search">
        <input type="submit" value="search">
    </form>
    <table class="wp-list-table widefat fixed striped table-view-list posts" id="emp-table">    
        <thead>
            <tr class="heading">
                <th>First Name <? echo $requestSearchText; ?></th>
                <th>Last Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php include('empDataTable.php');?>
        </tbody>
    </table>
</div>
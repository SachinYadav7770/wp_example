<div class="wrap">
    <h2>HTML Table</h2>
    <form action="<?php echo admin_url('admin.php');?>" id="cp_sub_page_search_form">
        <input type="hidden" name="page" value="my-submenu-handle">
        <input type="text" name="search" id="search">
        <input type="submit" value="search">
    </form>
    <button type="button" class='edit-employee'>Add Employee</button>
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
    <div class="container">
        <!-- <h2>Modal Example</h2> -->
        <!-- Trigger the modal with a button -->
        <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
        </div>

    </div>
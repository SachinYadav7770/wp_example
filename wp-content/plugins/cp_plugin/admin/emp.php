<div class="wrap">
    <h2>HTML Table</h2>
    <div class="row mb-1">
        <div class="col-6">
            <form action="<?php echo admin_url('admin.php');?>" id="cp_sub_page_search_form" class="float-left">
                <input type="hidden" name="page" value="my-submenu-handle">
                <input type="text" name="search" id="search">
                <input type="submit" value="search">
            </form>
        </div>
        <div class="col-6">
            <button type="button" class='edit-employee float-right btn btn-outline-success'>Add Employee</button>
        </div>
    </div>
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
            </div>

        </div>
    </div>

</div>
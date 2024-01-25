// console.log(ajaxAdminUrl );

jQuery(document).ready(function($) {
    jQuery("#cp_sub_page_search_form").submit(function(event){
        event.preventDefault();

        let search = jQuery("#search").val();
        let data = {
			'action': 'my_action',
			'search': search
		};
        let tableDataObj = jQuery("#emp-table").find('tbody');

        jQuery(tableDataObj).html('');
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
            response = $.parseJSON(response);
            if(response.html){
                jQuery(tableDataObj).html(response.html);
            }
		});
    });

    
    jQuery(".edit-employee").click(function(event){
        event.preventDefault();
        let emp_id = jQuery(this).closest('tr').data('employee-id');
        let data = {
			'action': 'edit_employee',
			'emp_id': emp_id
		};
        console.log(data);
        // return false;
        jQuery.post(ajaxurl, data, function(response) {
            response = $.parseJSON(response);
            console.log(response);
            
                    // $("#getCodeModal").modal("show");
            if(response.html){
                
                    // Add response in Modal body
                    jQuery('.modal-body').html(response.html);

                    // Display Modal
                    jQuery('#myModal').modal('show'); 
                // jQuery(tableDataObj).html(response.html);
            }
		});
        
        // console.log(jQuery(this).closest('tr').data('employee-id'));

    });

    jQuery(document).on('submit','#emp_form', function(event) {
        event.preventDefault();
        // alert('fasfasd');
        let formData = jQuery(this).serialize();
        let employeeId = jQuery(this).data('employee-id');
        
        let data = {
            'action': 'store_employee',
            'formData': formData+`&e_id=${employeeId}`
        };
        // let tableDataObj = jQuery("#emp-table").find('tbody');
        // console.log(jQuery(this).data('employee-id'));
        // jQuery(tableDataObj).html('');
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            response = $.parseJSON(response);
            console.log(response.response);
            if(response.response){
                // jQuery(tableDataObj).html(response.html);
            }
        });
    });


});

// jQuery("#emp_form").click(function(event){

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

        jQuery.post(ajaxurl, data, function(response) {
            response = $.parseJSON(response);
            console.log(response);
            if(response.html){
                // Add response in Modal body
                jQuery('.modal-body').html(response.html);
                // Display Modal
                jQuery('#myModal').modal('show'); 
            }
		});
    });

    jQuery(document).on('submit','#emp_form', function(event) {
        event.preventDefault();
        let formData = jQuery(this).serialize();
        let employeeId = jQuery(this).data('employee-id');
        
        let data = {
            'action': 'store_employee',
            'formData': formData+`&e_id=${employeeId}`
        };

        jQuery.post(ajaxurl, data, function(response) {
            response = $.parseJSON(response);
            console.log(response.response);
            if(response.response){
                // jQuery(tableDataObj).html(response.html);
            }
        });
    });

    
    jQuery(".delete-employee").click(function(event){
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if(!willDelete){
                return false;
            }

            swal({
                text: "Once deleted, you will not be able to recover this imaginary file!",
                target: "#toast-alert"
            });
            
            // let emp_id = jQuery(this).closest('tr').data('employee-id');
            // let data = {
            //     'action': 'delete_employee',
            //     'emp_id': emp_id
            // };

            // jQuery.post(ajaxurl, data, function(response) {
            //     response = $.parseJSON(response);
            //     console.log(response.response);
            //     if(response.response){
            //         swal("Poof! Your imaginary file has been deleted!", {
            //           icon: "success",
            //         });
            //     }else{
            //         swal("Your imaginary file is safe!");
            //     }
            // });
        });
        // confirm("Press a button!");
        // if(!confirm("Press a button!")){
        //     return false;
        // }
        // sweetAlert("title", "description", "error");
        // swal("Good job!", "You clicked the button!", "success");
//         let emp_id = jQuery(this).closest('tr').data('employee-id');
//         let data = {
// 			'action': 'delete_employee',
// 			'emp_id': emp_id
// 		};
// console.log(data);
        // jQuery.post(ajaxurl, data, function(response) {
        //     response = $.parseJSON(response);
        //     console.log(response.response);
        //     if(response.response){
        //         // jQuery(tableDataObj).html(response.html);
        //     }
        // });
    });


});
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

});
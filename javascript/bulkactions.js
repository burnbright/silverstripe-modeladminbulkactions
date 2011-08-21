//make actions ajax...and result replaces '.right' or '#ModelAdminPanel'

(function($) {
	
	$("#Form_ResultsForm").live('submit',function(event){
		
		var data  = $(this).formToArray();
		data['action_customAction'] = "customAction";
		var action  = $(this).attr('action')+"&action_customAction=action"; //FIXME: hacked in
		
		//TODO:: add a spinner?
		
	    $('#ModelAdminPanel').load(action,data, standardStatusHandler(function(result) {
	    	
			if(!this.future || !this.future.length) {
			    $('#Form_EditForm_action_goForward, #Form_ResultsForm_action_goForward').hide();
		    }
			if(!this.history || this.history.length <= 1) {
			    $('#Form_EditForm_action_goBack, #Form_ResultsForm_action_goBack').hide();
		    }

    		$('#form_actions_right').remove();
    		Behaviour.apply();

			if(window.onresize) window.onresize();
    		// Remove the loading indicators from the buttons
    		$('input[type=submit]', $form).removeClass('loading');
	    }, 
	    // Failure handler - we should still remove loading indicator
	
	    function () {
    		$('input[type=submit]', $form).removeClass('loading');
	    }));
	    return false;
	});
	
	
	function standardStatusHandler(callback, failureCallback) {
	    return function(response, status, xhr) {
	        // If the response is takne from $.ajax's complete handler, then swap the variables around
	        if(response.status) {
	            xhr = response;
	            response = xhr.responseText;
	        }

	        if(status == 'success') {
	            statusMessage(xhr.statusText, "good");
	            $(this).each(callback, [response, status, xhr]);
			} else {
	            errorMessage(xhr.statusText);
	            if(failureCallback) $(this).each(failureCallback, [response, status, xhr]);
			}
	    }
	}

})(jQuery);
function showConfirmDialog(params) {
	swal({
		title: params.title,
		text: params.text,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Si",
		cancelButtonText: "No",
		closeOnConfirm: false,
	}, function(isConfirm){
			if (isConfirm) {
				if (params.containImage)
				{
					$.ajax({
                        type : 'POST',
                        data: params.formData,
                        mimeType: "multipart/form-data",
                        processData: false,
                        contentType: false,
                          url: params.requestUrl, // target element(s) to be updated with server response 
                           cache : false,
                          success : function(response){ 
                        	  successAction(params.successTitle, params.successText, params.redirectUrl);
                           },
                           error : function(response){
                               failedAction(response, params.failedText)                                   
                           }
                    }); 
				}
				else
				{
					$.ajax({
						type : 'POST',
						dataType: 'json',
						data: params.formData,
				       	url: params.requestUrl, // target element(s) to be updated with server response 
				       	cache : false,
				       	success : function(response){ 
				       		successAction(params.successTitle, params.successText, params.redirectUrl);
				       	},
				       	error : function(response){
				       		failedAction(response, params.failedText)							       
				       	}
					});  					
				}
       
		  	}
	});
};
			
function successAction(successTitle, successText, redirectUrl) {
	swal({
   			title: successTitle != null ? successTitle : "Grabado", 
   			text: successText, 
   			type: "success"
   		},
   		function () {
   			window.location.href = redirectUrl;
   		}
   	);			
}
			
function failedAction(response, failedText, uniqueValues) {
	$(".fg-line").removeClass("has-error");
   	$(".alert").addClass("hide-alert");
   	var responseJSON = JSON.parse(response.responseText);
   	var errorType = responseJSON["error-type"];
   	var errorFields = responseJSON["error-fields"];
   	var alertsContainer = $("#error-alert-container");
   	for (var key in errorFields) {
    	if (errorFields[key] !== "") {
    		var alertTemplate = $("#error-message-template").html();
    		$("[data-id=" + key + "]").addClass("has-error");
    		alertTemplate = alertTemplate.replace("{alertText}", errorFields[key])
    		alertsContainer.append(alertTemplate);
    	}
    }    
   	swal({
   		title: "Error", 
   		text: failedText, 
   		type: "error"
   	});
}
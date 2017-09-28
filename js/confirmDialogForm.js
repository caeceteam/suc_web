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
				$.ajax({
						type : 'POST',
						dataType:'json',
						data: params.formData,
				       	url: params.requestUrl, // target element(s) to be updated with server response 
				       	cache : false,
				       	success : function(response){ 
				       		successAction(params.successText, params.redirectUrl);
				       	},
				       	error : function(response){
				       		failedAction(response, params.failedText)							       
				       	}
				});        
		  	}
	});
};
			
function successAction(successText, redirectUrl) {
   	swal({
   			title: "Grabado", 
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
   	var errorType = response.responseJSON["error-type"];
   	var errorFields = response.responseJSON["error-fields"];
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
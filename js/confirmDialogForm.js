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
				       		failedAction(response, params.failedText, params.uniqueValues)							       
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
   	if (errorType === "unique") {
		$("#unique-error-alert").removeClass("hide-alert");
		for (var i = 0; i < uniqueValues.length; i++) {
	    	if (uniqueValues[i] !== "") {
	    		$("[data-id=" + uniqueValues[i] + "]").addClass("has-error");
	    	}
		}
    }
    if (errorType === "empty-field") {
    	$("#empty-error-alert").removeClass("hide-alert");
    	var errors = response.responseJSON["message"];
    	for (var key in errors) {
	    	if (errors[key] !== "") {
	    		$("[data-id=" + key + "]").addClass("has-error");
	    	}
	    }
	}
   	swal({
   		title: "Error", 
   		text: failedText, 
   		type: "error"
   	});
}
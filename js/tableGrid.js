function loadBootgrid(params) {
	$(params.selector).bootgrid({
    	ajax: true,
    	url : params.requestUrl,
    	labels: {
        	noResults: params.noResultText,
            search: params.searchTxt == null ? "Buscar" : params.searchTxt,
            infos: params.infos
        },
        css: {
            icon: 'zmdi icon',
            iconColumns: 'zmdi-view-module',
            iconDown: 'zmdi-expand-more',
            iconRefresh: 'zmdi-refresh',
            iconUp: 'zmdi-expand-less'
        },
        formatters: {
        	"commands": function(column, row) {
        		var editButtons = "<a title=\"Editar\" type=\"button\" href=\"" + params.editUrl + row.id + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> ";
              	var deleteButton = "<a title=\"Borrar\" id=\"sa-warning\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></a> "; 
        		
        		if (params.hasAssistants) {
        			var assistantButtons =  " <a title=\"Concurrentes\" type=\"button\" href=\"" + params.assistantUrl + row.id + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-accounts zmdi-hc-fw\"></span></a> ";
        			return assistantButtons + editButtons + deleteButton;	
        		}
        		if (params.isDonationGrid) {
        			if (row.state === "Aprobado") {
        				return "";
        			}
        		}
        		if (!params.showDelete) {
        			return editButtons;
        		}

        		return editButtons + deleteButton;            
        	}
        }
    }).on("loaded.rs.jquery.bootgrid", function () {
    	$(this).find(".command-delete").off();
        $(this).find(".command-edit").off();
		$(this).find(".command-delete").click(function (e) {
			var deleteUrl = params.deleteUrl + this.getAttribute("data-row-id");
			swal({
				title: params.deleteDialogTitle,
				text: params.deleteDialogText,
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Si",
				cancelButtonText: "No",
				closeOnConfirm: false
			}, 
			function(isConfirm){
				if (isConfirm) {
					$.ajax({ 
						type: "DELETE",
					   	url: deleteUrl,
					   	success: function(data){
					   		swal("Borrado", params.deleteDialogSuccess, "success");
						   	$('#data-table-command').bootgrid('reload');
					   	}
					});
				}
			});
		});
	});	
}
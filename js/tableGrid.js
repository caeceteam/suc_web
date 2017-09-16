function loadBootgrid(params) {
	$(params.selector).bootgrid({
    	ajax: true,
    	url : params.requestUrl,
    	labels: {
        	noResults: params.noResultText,
            search: "Buscar",
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
            	return "<a type=\"button\" href=\"" + params.editUrl + row.id + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> " + 
                	"<a id=\"sa-warning\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></a>";
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
					   		swal("¡Borrado!", params.deleteDialogSuccess, "success");
						   	$('#data-table-command').bootgrid('reload');
					   	}
					});
				}
			});
		});
	});	
}
				
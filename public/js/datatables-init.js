(function ($) {
    /*  Data Table -------------*/
    $('#bootstrap-data-table').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		language: {
			url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
		},
		responsive: true
    });

    $('#bootstrap-data-table-export').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
		language: {
			url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
		},
		responsive: true
	});
	$('#bootstrap-data-table-export-2').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
		language: {
			url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
		},
		responsive: true
    });

	$('#row-select').DataTable({
		language: {
			url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
		},
		responsive: true,
        initComplete: function () {
				this.api().columns().every(function () {
					var column = this;
					var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo($(column.footer()).empty())
						.on('change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);

							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						});

					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				});
			}
		});

})(jQuery);

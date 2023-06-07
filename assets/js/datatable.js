$(document).ready(function() {
  $.extend(true, $.fn.dataTable.defaults, {
    "language": {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "<i class='fa fa-arrow-right'></i>",
        "sPrevious": "<i class='fa fa-arrow-left'></i>"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
    }
  });

  function inicializarTabla(tablaId) {
    var tabla = $('#' + tablaId).DataTable({
    dom: 'Bfrtip',
    buttons: [ 
      {
        extend: 'excelHtml5',
        text: '<i class="fas fa-file-excel"></i> ',
        titleAttr: 'Exportar a Excel',
        className: 'btn btn-success',
        exportOptions: {
          columns: ':not(:first-child)' // Excluir la primera columna (Acción)
        }
      },
      {
        extend: 'pdfHtml5',
        text: '<i class="fas fa-file-pdf"></i> ',
        titleAttr: 'Exportar a PDF',
        className: 'btn btn-danger',
        exportOptions: {
          columns: ':not(:first-child)' // Excluir la primera columna (Acción)
        }
      },
      {
        extend: 'print',
        text: '<i class="fa fa-print"></i> ',
        titleAttr: 'Imprimir',
        className: 'btn btn-info',
        exportOptions: {
          columns: ':not(:first-child)' // Excluir la primera columna (Acción)
        }
      },
    ],
    "paging": false,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "pageLength": 5,
    orderCellsTop: true,
    fixedHeader: true,

  });

  // Creamos una fila en el head de la tabla y lo clonamos para cada columna
  $('#' + tablaId + ' thead tr').clone(true).appendTo('#' + tablaId + ' thead');

  $('#' + tablaId + ' thead tr:eq(1) th').each(function (i) {
    if (i !== 0) { // Excluir la primera columna (Acción)
      var title = $(this).text(); 
      $(this).html('<input type="text" placeholder="Buscar por..' + title + '" />');

      $('input', this).on('keyup change', function () {
        if (tabla.column(i).search() !== this.value) {
          tabla
            .column(i)
            .search(this.value)
            .draw();
        }
      });
    }
  });
}

inicializarTabla('tabla-lista');
inicializarTabla('tablaDep');
inicializarTabla('tablaFormatos');
inicializarTabla('tablaTut');
inicializarTabla('tablaUsu');
});
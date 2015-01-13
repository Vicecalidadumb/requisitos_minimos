var TableAjax = function() {

    var initPickers = function() {
//init date pickers
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
    }
//ENVIO DE DATOS VERSIONES ANTERIORES A 1.9 - http://datatables.net/manual/server-side#Legacy
    $.fn.dataTable.ext.legacy.ajax = true;
    var handleRecords = function() {
        var grid = new Datatable();
        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function(grid) {
                // execute some code after table records loaded
            },
            onError: function(grid) {
                // execute some code on network or other general error  
            },
            dataTable: {
                "drawCallback": function() {
                    Metronic.unblockUI('#blockui_sample_3_2_element');
                },
                "fnPreDrawCallback": function() {
                    Metronic.blockUI({
                    target: '#blockui_sample_3_2_element',
                    boxed: false,
                    message:' ',
                    iconOnly: false,
                    textOnly: true
                });
                },
                "sPaginationType": "full_numbers",
                "processing": true,
                "serverSide": true,
                "dom": "<'row'<'col-md-12 col-sm-12'pli><'col-md-12 col-sm-12'<'table-group-actions pull-right'>f>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                "lengthMenu": [
                    [10, 20, 50, 100],
                    [10, 20, 50, 100] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": base_url_js + "index.php/aspirantes/get_datatable",
                "fnServerParams": function(aoData) {
                    aoData.push({"name": "bSearchable2_0", "value": $("#bSearchable2_0").val()});
                    aoData.push({"name": "bSearchable2_1", "value": $("#bSearchable2_1").val()});
                    aoData.push({"name": "bSearchable2_2", "value": $("#bSearchable2_2").val()});
                    aoData.push({"name": "bSearchable2_3", "value": $("#bSearchable2_3").val()});
                    aoData.push({"name": "bSearchable2_4", "value": $("#bSearchable2_4").val()});
                },
                "bFilter": false,
                "order": [
                    [0, "asc"]
                ],
                "aoColumnDefs": [
                    {"bSortable": true, "aTargets": [0]},
                    {"bSortable": true, "aTargets": [1]},
                    {"bSortable": true, "aTargets": [2]},
                    {"bSortable": true, "aTargets": [3]},
                    {"bSortable": true, "aTargets": [4]},
                    {"bSortable": false, "aTargets": [5]},
                    {"bSortable": false, "aTargets": [6]},
                    {"bSortable": false, "aTargets": [7]},
                    {"bSearchable": false, "aTargets": [0]},
                    {"bSearchable": false, "aTargets": [1]},
                    {"bSearchable": true, "aTargets": [2]},
                    {"bSearchable": false, "aTargets": [3]},
                    {"bSearchable": false, "aTargets": [4]},
                    {"bSearchable": false, "aTargets": [5]},
                    {"bSearchable": false, "aTargets": [6]},
                ],
                "language": {// language settings
                    "sProcessing": "Procesando...",
                    "sInfoFiltered": "(filtrado de un total de _MAX_)",
                    "sSearch": "Buscar por documento:",
                    // metronic spesific
                    "metronicGroupActions": "_TOTAL_ records selected: ",
                    "metronicAjaxRequestGeneralError": "Error al consultar, por favor verifique la conexion.",
                    // data tables spesific
                    "lengthMenu": "<span class='seperator'>|</span>Mostrando _MENU_ registros",
                    "info": "<span class='seperator'>|</span>Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "infoEmpty": "<span class='seperator'>|</span>Mostrando registros del 0 al 0 de un total de 0",
                    "emptyTable": "Ningun dato disponible en esta tabla",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Proxima",
                        "last": "Ultima",
                        "first": "Primera",
                        "page": "Pagina",
                        "pageOf": "de"
                    }
                }
            }
        });
        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function(e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    }

    return {
//main function to initiate the module
        init: function() {

            initPickers();
            handleRecords();
        }

    };
}();
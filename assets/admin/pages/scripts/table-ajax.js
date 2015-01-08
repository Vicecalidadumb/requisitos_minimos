var TableAjax = function() {

    var initPickers = function() {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
    }

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
            loadingMessage: 'Cargando Datos...',
            dataTable: {
                "sPaginationType": "full_numbers",
                "processing": true,
                "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>f>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": base_url_js + "index.php/profile/ajax_datatable",
                "order": [
                    [1, "asc"]
                ],
                "language": {// language settings
                    // metronic spesific
                    "metronicGroupActions": "_TOTAL_ records selected: ",
                    "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
                    // data tables spesific
                    "lengthMenu": "<span class='seperator'>|</span>View _MENU_ records",
                    "info": "<span class='seperator'>|</span>Found total _TOTAL_ records",
                    "infoEmpty": "No records found to show",
                    "emptyTable": "No data available in table",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First",
                        "page": "Page",
                        "pageOf": "of"
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
<?php
include "session.php"; include "functions.php";
if (($rPermissions["is_reseller"]) && (!$rPermissions["create_sub_resellers"])) { exit; }
if (($rPermissions["is_admin"]) && (!hasPermissions("adv", "mng_regusers"))) { exit; }

if ($rPermissions["is_admin"]) {
    $rRegisteredUsers = getRegisteredUsers();
} else {
    $rRegisteredUsers = getRegisteredUsers($rUserInfo["id"]);
}

if ($rSettings["sidebar"]) {
    include "header_sidebar.php";
} else {
    include "header.php";
}
        if ($rSettings["sidebar"]) { ?>
        <div class="content-page"><div class="content"><div class="container-fluid">
        <?php } else { ?>
        <div class="wrapper"><div class="container-fluid">
        <?php } ?>
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li>
                                        <a href="#" onClick="clearFilters();">
                                            <button type="button" class="btn btn-warning waves-effect waves-light btn-sm">
                                                <i class="mdi mdi-filter-remove"></i>
                                            </button>
                                        </a>
                                        <a href="#" onClick="changeZoom();">
                                            <button type="button" class="btn btn-info waves-effect waves-light btn-sm">
                                                <i class="mdi mdi-magnify"></i>
                                            </button>
                                        </a>
                                        <?php if (!$detect->isMobile()) { ?>
                                        <a href="#" onClick="toggleAuto();">
                                            <button type="button" class="btn btn-dark waves-effect waves-light btn-sm">
                                                <i class="mdi mdi-refresh"></i> <span class="auto-text">Autorefrescar</span>
                                            </button>
                                        </a>
                                        <?php } else { ?>
                                        <a href="javascript:location.reload();" onClick="toggleAuto();">
                                            <button type="button" class="btn btn-dark waves-effect waves-light btn-sm">
                                                <i class="mdi mdi-refresh"></i> Refresh
                                            </button>
                                        </a>
                                        <?php }
										if ((hasPermissions("adv", "add_reguser")) OR ($rPermissions["is_reseller"])) { ?>
                                        <a href="<?php if ($rPermissions["is_admin"]) { echo "reg_user"; } else { echo "subreseller"; } ?>.php">
                                            <button type="button" class="btn btn-success waves-effect waves-light btn-sm">
                                                <i class="mdi mdi-plus"></i> Añadir <?php if ($rPermissions["is_admin"]) { ?>usuario registrado<?php } else { ?>Subvendedor<?php } ?>
                                            </button>
                                        </a>
										<?php } ?>
                                    </li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php if ($rPermissions["is_admin"]) { ?>Usuarios Registrados<?php } else { ?>Sub-revendedores<?php } ?></h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title --> 
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="overflow-x:auto;">
                                <form id="reg_users_search">
                                    <div class="form-group row mb-4">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="reg_search" value="" placeholder="Buscar usuarios ...">
                                        </div>
                                        <label class="col-md-2 col-form-label text-center" for="reg_reseller">Filtrar Resultados</label>
                                        <div class="col-md-3">
                                            <select id="reg_reseller" class="form-control" data-toggle="select2">
                                                <option value="" selected>Todos los propietarios</option>
                                                <?php if ($rPermissions["is_admin"]) { ?>
                                                <option value="0">Sin dueño</option>
                                                <?php } foreach ($rRegisteredUsers as $rRegisteredUser) { ?>
                                                <option value="<?=$rRegisteredUser["id"]?>"><?=$rRegisteredUser["username"]?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select id="reg_filter" class="form-control" data-toggle="select2">
                                                <option value="" selected>No Filter</option>
                                                <option value="1">Activo</option>
                                                <option value="2">Apagado</option>
                                            </select>
                                        </div>
                                        <label class="col-md-1 col-form-label text-center" for="reg_show_entries">mostrar</label>
                                        <div class="col-md-1">
                                            <select id="reg_show_entries" class="form-control" data-toggle="select2">
                                                <?php foreach (Array(10, 25, 50, 250, 500, 1000) as $rShow) { ?>
                                                <option<?php if ($rAdminSettings["default_entries"] == $rShow) { echo " selected"; } ?> value="<?=$rShow?>"><?=$rShow?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <table id="datatable-users" class="table dt-responsive nowrap font-normal">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Username</th>
                                            <th>Owner</th>
                                            <th class="text-center">IP</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Créditos</th>
                                            <th class="text-center">Usuarios</th>
                                            <th class="text-center">Último acceso</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
                <!-- end row-->
            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->
        <?php if ($rSettings["sidebar"]) { echo "</div>"; } ?>
        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 copyright text-center"><?=getFooter()?></div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/libs/jquery-toast/jquery.toast.min.js"></script>
        <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables/dataTables.bootstrap4.js"></script>
        <script src="assets/libs/select2/select2.min.js"></script>
        <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables/buttons.flash.min.js"></script>
        <script src="assets/libs/datatables/buttons.print.min.js"></script>
        <script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="assets/libs/datatables/dataTables.select.min.js"></script>
        <script src="assets/js/pages/form-remember.js"></script>
        <script src="assets/js/app.min.js"></script>

        <script>
        var autoRefresh = true;
        var rClearing = false;
        
        function api(rID, rType) {
            if (rType == "Eliminar") {
                if (confirm('¿Está seguro de que desea eliminar este usuario registrado?') == false) {
                    return;
                }
            }
            $.getJSON("./api.php?action=reg_user&sub=" + rType + "&user_id=" + rID, function(data) {
                if (data.result === true) {
                    if (rType == "Eliminar") {
                        $.toast("El usuario ha sido eliminado.");
                    } else if (rType == "habilitar") {
                        $.toast("El usuario ha sido habilitado.");
                    } else if (rType == "inhabilitar") {
                        $.toast("El usuario ha sido deshabilitado.");
					} else if (rType == "Reiniciar") {
                        $.toast("Se ha restablecido la autenticación de dos factores para este usuario.");
                    }
                    $('[data-toggle="tooltip"]').tooltip("hide");
                    $("#datatable-users").DataTable().ajax.reload(null, false);
                } else {
                    $.toast("Ocurrió un error al procesar su solicitud.");
                }
            });
        }
        function toggleAuto() {
            if (autoRefresh == true) {
                autoRefresh = false;
                $(".auto-text").html("Modo manual");
            } else {
                autoRefresh = true;
                $(".auto-text").html("Autorefrescar");
            }
        }
        function getFilter() {
            return $("#reg_filter").val();
        }
        function getReseller() {
            return $("#reg_reseller").val();
        }
        function reloadUsers() {
            if (autoRefresh == true) {
                $('[data-toggle="tooltip"]').tooltip("hide");
                $("#datatable-users").DataTable().ajax.reload(null, false);
            }
            setTimeout(reloadUsers, 5000);
        }
        function changeZoom() {
            if ($("#datatable-users").hasClass("font-large")) {
                $("#datatable-users").removeClass("font-large");
                $("#datatable-users").addClass("font-normal");
            } else if ($("#datatable-users").hasClass("font-normal")) {
                $("#datatable-users").removeClass("font-normal");
                $("#datatable-users").addClass("font-small");
            } else {
                $("#datatable-users").removeClass("font-small");
                $("#datatable-users").addClass("font-large");
            }
            $("#datatable-users").DataTable().draw();
        }
        function clearFilters() {
            window.rClearing = true;
            $("#reg_search").val("").trigger('change');
            $('#reg_filter').val("").trigger('change');
            $('#reg_reseller').val("").trigger('change');
            $('#reg_show_entries').val("<?=$rAdminSettings["default_entries"] ?: 10?>").trigger('change');
            window.rClearing = false;
            $('#datatable-users').DataTable().search($("#reg_search").val());
            $('#datatable-users').DataTable().page.len($('#reg_show_entries').val());
            $("#datatable-users").DataTable().page(0).draw('page');
            $('[data-toggle="tooltip"]').tooltip("hide");
            $("#datatable-users").DataTable().ajax.reload( null, false );
        }
        $(document).ready(function() {
			$(window).keypress(function(event){
                if(event.which == 13 && event.target.nodeName != "TEXTAREA") return false;
            });
            formCache.init();
            formCache.fetch();
            
            $.fn.dataTable.ext.errMode = 'none';
            $('select').select2({width: '100%'});
            $("#datatable-users").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    $('[data-toggle="tooltip"]').tooltip();
                },
                createdRow: function(row, data, index) {
                    $(row).addClass('user-' + data[0]);
                },
                responsive: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "./table_search.php",
                    "data": function(d) {
                        d.id = "reg_users",
                        d.filter = getFilter(),
                        d.reseller = getReseller()
                    }
                },
                columnDefs: [
                    {"className": "dt-center", "targets": [0,3,4,5,6,7,8,9]},
                    <?php if ($rPermissions["is_reseller"]) { ?>
                    {"visible": false, "targets": [4]}
                    <?php } ?>
                ],
                order: [[ 0, "desc" ]],
                stateSave: true
            });
            $("#datatable-users").css("width", "100%");
            $('#reg_search').keyup(function(){
                if (!window.rClearing) {
                    $('#datatable-users').DataTable().search($(this).val()).draw();
                }
            });
            $('#reg_show_entries').change(function(){
                if (!window.rClearing) {
                    $('#datatable-users').DataTable().page.len($(this).val()).draw();
                }
            });
            $('#reg_filter').change(function(){
                if (!window.rClearing) {
                    $('[data-toggle="tooltip"]').tooltip("hide");
                    $("#datatable-users").DataTable().ajax.reload( null, false );
                }
            });
            $('#reg_reseller').change(function(){
                if (!window.rClearing) {
                    $('[data-toggle="tooltip"]').tooltip("hide");
                    $("#datatable-users").DataTable().ajax.reload( null, false );
                }
            });
            <?php if (!$detect->isMobile()) { ?>
            setTimeout(reloadUsers, 5000);
            <?php }
            if (!$rAdminSettings["autorefrescar"]) { ?>
            toggleAuto();
            <?php } ?>
            if ($('#reg_search').val().length > 0) {
                $('#datatable-users').DataTable().search($('#reg_search').val()).draw();
            }
        });
        
        $(window).bind('beforeunload', function() {
            formCache.save();
        });
        </script>
    </body>
</html>
<?php ini_set("session.gc_maxlifetime", "18000"); ?>
<?php session_start(); ?>
<?php $_SESSION['gpage'] = 1; ?>
<?php //var_dump($_SESSION);  ?>



            <div class="accordion menu_principal" >
                    
                <?php if ($_SESSION['acceso_contabilidad'] == 'false') {
                    ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Contabilidad</h3>
                    <p>

                        <span class="foldertreeview">Compras</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librocompra/grid_registro_compra.php','#CapaContenedorFormulario')">
                                Registro de Compras
                            </a>
                        </span>
                                                <!--<br><span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librocompra/grid_registro_compra2.php','#CapaContenedorFormulario')">
                                PRUEBA_NO_TOCAR - R.Compras
                            </a>
                        </span> -->

                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/migrar/form_migrar.php','#CapaContenedorFormulario')">
                                Migrar de Almacen
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Ventas </span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libroventa/grid_registro_venta.php','#CapaContenedorFormulario')">
                                Registro de Ventas</a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/migrar/form_migrar_venta.php','#CapaContenedorFormulario')">
                                Migrar-Ventas-Arqueos</a>
                        </span>
                        <br/>						<span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/migrar/form_migrar_manvta.php','#CapaContenedorFormulario')">
                                Migrar-Ventas Manuales</a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Libro Caja</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librocaja/grid_caja_ingreso_soles.php','#CapaContenedorFormulario')">
                                Ingreso Soles</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librocaja/grid_caja_ingreso_dolar.php','#CapaContenedorFormulario')">
                                Ingreso Dolares</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librocaja/grid_caja_egreso_soles.php','#CapaContenedorFormulario')">
                                Egreso Soles</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librocaja/grid_caja_egreso_dolar.php','#CapaContenedorFormulario')">
                                Egreso Dolares</a></span>
                        <br/>
                        <span class="foldertreeview">Libro Bancos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librobanco/grid_banco_deposito.php','#CapaContenedorFormulario')">
                                Ingresos-Deposito</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librobanco/grid_banco_ingreso.php','#CapaContenedorFormulario')">
                                Ingresos</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librobanco/grid_banco_egreso.php','#CapaContenedorFormulario')">
                                Egresos</a></span>
                        <br/>
                        <span class="foldertreeview">Asiento de Diario</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/librodiario/grid_asiento_diario.php','#CapaContenedorFormulario')">
                                Registrar Asiento</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libroapert/grid_asiento_apert.php','#CapaContenedorFormulario')">
                                Asiento de Apertura</a></span>
                        <br/>
                        <span class="foldertreeview">Provisiones</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libroprovisiones/grid_asiento_provisiones.php','#CapaContenedorFormulario')">
                                Centro de Costo</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/migrar/form_migrar_costo.php','#CapaContenedorFormulario')">
                                Migrar Costos Almacen
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Archivos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/plancontable/grid_plan_contable.php','#CapaContenedorFormulario')">
                                Plan Contable</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/banco/grid_bancos.php','#CapaContenedorFormulario')">
                                Bancos</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/tipocambio/grid_tipo_cambio.php','#CapaContenedorFormulario')">
                                Tipo de Cambio</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/anexo/grid_anexo.php','#CapaContenedorFormulario')">
                                RUC</a>                </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/mediopago/grid_medio_pago.php','#CapaContenedorFormulario')">
                                MEDIO PAGO</a></span>
                        <br/>
                    <?php } ?>

                    <?php if ($_SESSION['acceso_contabilidad'] == 'false') {
                        ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Libros y Registros</h3>
                    <p>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_caja.php','#CapaContenedorFormulario')">
                            1.1F:Libro Caja y Bancos-Efectivo</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_bancos.php','#CapaContenedorFormulario')">
                            1.2F:Libro Caja y Bancos-Bancos</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_efplan_bg.php','#CapaContenedorFormulario')">
                            3.1F:Balance General</a></span>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_10.php','#CapaContenedorFormulario')">
                            3.2F:10 Efectivo y Equivalentes</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_12.php','#CapaContenedorFormulario')">
                            3.3F:12 Ctas x Cobrar Comerciales</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_14.php','#CapaContenedorFormulario')">
                            3.4F:14 Ctas x Cobrar al Personal</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_16.php','#CapaContenedorFormulario')">
                            3.5F:16 Ctas x Cobrar Diversas</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_19.php','#CapaContenedorFormulario')">
                            3.6F:19 Cobranza dudosa</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_20.php','#CapaContenedorFormulario')">
                            20 Mercaderias</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_21.php','#CapaContenedorFormulario')">
                            21 Productos Terminados</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_24.php','#CapaContenedorFormulario')">
                            24 Materias Primas</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_25.php','#CapaContenedorFormulario')">
                            25 Materiales Auxiliares</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_invbal.php','#CapaContenedorFormulario')">
                            - Lib.Inventario y Balances</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_40.php','#CapaContenedorFormulario')">
                            40 Tributos</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_41.php','#CapaContenedorFormulario')">
                            3.11F:41 Remuneraciones x Pagar</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_42.php','#CapaContenedorFormulario')">
                            3.12F:42 Proveedores</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_44.php','#CapaContenedorFormulario')">
                            44 Ctas x Pagar Accionistas</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_45.php','#CapaContenedorFormulario')">
                            45 Obligaciones Financiera</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_46.php','#CapaContenedorFormulario')">
                            3.13F:46 Ctas x Pagar Diversas</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_balcomp.php','#CapaContenedorFormulario')">
                            3.17F:Balance Comprobacion</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_invbal_egpfun.php','#CapaContenedorFormulario')">
                            3.20F:EGP Por Funcion</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_diario.php','#CapaContenedorFormulario')">
                            5.1F:Libro Diario</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_diario_simplificado.php','#CapaContenedorFormulario')">
                            5.2F:Libro Diario Simplificado</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_mayor.php','#CapaContenedorFormulario')">
                            6.1F:Libro Mayor</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_compra.php','#CapaContenedorFormulario')">
                            8.1F:Registro de Compras</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Almacen/AlmacenInventarioFisicoForm.php','#CapaContenedorFormulario')">
                            12.1F:Detalle del Inventario Permanente en Unidades Fisicas</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Almprod/AlmacenInventarioValorizadoForm.php','#CapaContenedorFormulario')">
                            13.1F:Detalle del Inventario Valorizado</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_libro_venta.php','#CapaContenedorFormulario')">
                            14.1F:Registro de Ventas e Ingresos</a>
                        <br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_ventaslocal.php','#CapaContenedorFormulario')">
                            - Registro de Ventas x Local</a>
                        <br/>
                    </p>
                <?php } ?>
                <?php if ($_SESSION['acceso_contabilidad'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Procesos</h3>
                    <p>
                        <span class="foldertreeview">Procesos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/procesos/form_proces_libro_mayor.php','#CapaContenedorFormulario')">
                                Mayorizacion General Nuevos Soles</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/procesos/form_proces_libro_mayordolar.php','#CapaContenedorFormulario')">
                                Mayorizacion General Moneda Extranjera</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/procesos/form_proces_asiento_automatico.php','#CapaContenedorFormulario')">
                                Generar Asto Automatico</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/procesos/form_proces_consis_voucher.php','#CapaContenedorFormulario')">
                                Consistencia Voucher</a></span>
                        <br/>
                        <span class="foldertreeview">Estados Financieros</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_efplan_bg.php','#CapaContenedorFormulario')">
                                Balance General</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_efplan_egpnat.php','#CapaContenedorFormulario')">
                                EGP-Naturaleza</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_efplan_egpfun.php','#CapaContenedorFormulario')">
                                EGP-Funcion</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_efplan_bganexo.php','#CapaContenedorFormulario')">
                                Anexo-Balance General</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_efplan_bghist.php','#CapaContenedorFormulario')">
                                Balance.General-Historico</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_balcosto.php','#CapaContenedorFormulario')">
                                Analisis de Centro Costos</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_bal9.php','#CapaContenedorFormulario')">
                                Analisis de Clase 9</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_bal6.php','#CapaContenedorFormulario')">
                                Analisis de Clase 6</a></span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_bal7.php','#CapaContenedorFormulario')">
                                Analisis de Clase 7</a></span>
                    </p>
                <?php } ?>
                <?php if ($_SESSION['acceso_contabilidad'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Reportes Contabilidad</h3>
                    <p>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_3.php','#CapaContenedorFormulario')">
                            Cta.Cte.RUC.Doc.Movimiento</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_cta_pendiente.php','#CapaContenedorFormulario')">
                            Cta.Cte.RUC.Doc.Pendientes</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_cta_movpendiente.php','#CapaContenedorFormulario')">
                            Cta.Cte.RUC.Mov.Doc.Pendientes</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_personalizado_generar_libro_compras.php','#CapaContenedorFormulario')">
                            Resumen de Compras</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_ventas_mes.php','#CapaContenedorFormulario')">
                            Resumen de Ventas</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_generar_mayor_cuenta.php','#CapaContenedorFormulario')">
                            Libro Mayor por Cuenta</a><br/>
                        <a class="linka1" href="javascript:cargar_pagina('gerencia/form_reporte_vtames.php','#CapaContenedorFormulario')">
                            Cuadro de Ventas-SUNAT</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_cta_sinruc.php','#CapaContenedorFormulario')">
                            Cta.Cte.Cuenta.Movimiento</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_cta_cabezera2.php','#CapaContenedorFormulario')">
                            Cta.Cte.Cuenta.Movimiento-RUC</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_cta_tipo.php','#CapaContenedorFormulario')">
                            Cta.Cte.Cuenta.Tipo-Documento</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_cta_pendruc.php','#CapaContenedorFormulario')">
                            Cta.Cte.Cuenta.Pendiente-RUC</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_txt_cta_pendruc.php','#CapaContenedorFormulario')">
                            TXTCta.Cte.Cuenta.Pendiente-RUC</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_work_bancos_soles.php','#CapaContenedorFormulario')">
                            Libro Bancos Soles</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_work_bancos_dolar.php','#CapaContenedorFormulario')">
                            Libro Bancos Dolares</a><br>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_balcta.php','#CapaContenedorFormulario')">
                            Balance por Cuenta Anual</a><br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/libros/form_reporte_balctames.php','#CapaContenedorFormulario')">
                            Balance por Cuenta Mensual</a><br/>
                    </p>
                <?php } ?>
                <?php if ($_SESSION['acceso_contabilidad'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">SUNAT</h3>
                    <p>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/procesos/form_daot_2012.php','#CapaContenedorFormulario')">
                            DAOT 2012</a><br/>
                        <a class="linka1" href="javascript:cargar_pagina('Contabilidad/procesos/form_sunatbc_2012.php','#CapaContenedorFormulario')">
                            PDT - 670</a><br/>
                    </p>
                <?php } ?>
                <?php if ($_SESSION['acceso_produccion'] == 'false') {
                    ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Produccion</h3>
                    <p>

                        <span class="foldertreeview">Gestion de Productos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Produccion/grid_registro_producto.php','#CapaContenedorFormulario')">
                                Productos
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Produccion/grid_producto_elaborado.php','#CapaContenedorFormulario')">
                                Productos Elaborados
                            </a>
                        </span>
                        <br>
                        <span class="foldertreeview">Formulacion</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Produccion/form_hoja_produccion.php','#CapaContenedorFormulario')">
                                Generar
                            </a>
                        </span>
                        <br>
                        <span class="foldertreeview">Hoja de Produccion</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Produccion/grid_hoja_produccion.php','#CapaContenedorFormulario')">
                                Gestionar Hoja
                            </a>
                        </span>
                        <br>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Produccion/grid_hoja_web.php','#CapaContenedorFormulario')">
                                Hoja de Produccion
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Produccion/grid_hoja_producto_fecha.php','#CapaContenedorFormulario')">
                                Productos por Fecha
                            </a>
                        </span>

                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_contabilidad'] == 'false') { ?>
                    <?php //if ($_SESSION['acceso_costos'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Costos</h3>
                    <p>
                        <span class="foldertreeview">Mantenimiento</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Costos/costogestion/grid.php','#CapaContenedorFormulario')">
                                Gestion Costos
                            </a>
                        </span>
                        <br>
                        <span class="foldertreeview">Reporte</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Costos/form_inventario_final.php','#CapaContenedorFormulario')">
                                Inventario Final
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Costos/form_determinacion_cuenta.php','#CapaContenedorFormulario')">
                                Costo por Cuenta
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Costos/form_determinacion_costo.php','#CapaContenedorFormulario')">
                                Determinacion del Costo
                            </a>
                        </span>
                    </p>
                <?php } ?>


                <?php if ($_SESSION['acceso_tesoreria'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Tesoreria</h3>
                    <p>
                        <span class="foldertreeview">Caja Chica</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Tesoreria/grid_recibo_pago.php','#CapaContenedorFormulario')">
                                Recibos
                            </a>
                        </span>
                        <br>
                        <span class="foldertreeview">Pagos Almacen</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Tesoreria/grid_almacen_fondo.php','#CapaContenedorFormulario')">
                                Con Fondo Fijo
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Tesoreria/grid_almacen_cheque.php','#CapaContenedorFormulario')">
                                Con Cheque Voucher
                            </a>
                        </span>
                        <br>
                        <span class="foldertreeview">Pagos Contabilidad</span><br/>        
                        <span class="icn1">        
                            <a class="linka1" href="javascript:cargar_pagina('Tesoreria/grid_contabilidad_fondo.php','#CapaContenedorFormulario')">
                                Con Fondo Fijo        
                            </a>        
                        </span>        
                        <br>        
                        <span class="icn1">        
                            <a class="linka1" href="javascript:cargar_pagina('Tesoreria/grid_contabilidad_cheque.php','#CapaContenedorFormulario')">
                                Con Cheque Voucher        
                            </a>        
                        </span>        
                        <br>

                        <span class="foldertreeview">Fondo Fijo</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Tesoreria/grid_fondo_fijo.php','#CapaContenedorFormulario')">
                                Registrar Fondo
                            </a>
                        </span>

                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_planillas'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Control de Asistencia</h3>
                    <p>                       
                        <span class="foldertreeview">Control Asistencia</span><br/>                       
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmControlAsistencia/view.php','#CapaContenedorFormulario')">
                                Gestionar Control
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmJustificacion/view.php','#CapaContenedorFormulario')">
                                Justificaciones
                            </a>
                        </span>
                        <br/>

                        <span class="foldertreeview">Gestionar</span><br/>                       
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmTurno/new.php','#CapaContenedorFormulario')">
                                Nuevo Turno Normal
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmTurno/new_doble.php','#CapaContenedorFormulario')">
                                Nuevo Turno Doble
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmTurno/view.php','#CapaContenedorFormulario')">
                                Lista Turno
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmFeriado/new.php','#CapaContenedorFormulario')">
                                Feriados
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmTipoJustificacion/new.php','#CapaContenedorFormulario')">
                                Tipo Justificacion
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmCargo/new.php','#CapaContenedorFormulario')">
                                Gestion de Cargos
                            </a>
                        </span>
                        <br/>

                        <span class="foldertreeview">Administrativo</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmGrupo/view.php?idLocal=1&tipocargo=A','#CapaContenedorFormulario')">
                                Gestion Personal
                            </a>
                        </span>
                        <br/>                                                                 
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('personal/AdmHorario/view.php?idLocal=1&tipocargo=A','#CapaContenedorFormulario')">
                                Gestion Horarios
                            </a>
                        </span>
                        <br/>                                              

                    </p>

                <?php } ?>   


                <?php if ($_SESSION['acceso_cajageneral'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Gestion Caja General</h3>
                    <p>
                        <span class="foldertreeview">Depositos</span><br/> 
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajage/grid_deposito.php','#CapaContenedorFormulario')">
                                Confirmar Depositos
                            </a>
                        </span>
                        <br/>

                        <span class="foldertreeview">Gastos de personal</span><br/>                         
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastoge/grid_gasto.php','#CapaContenedorFormulario')">
                                Consumos de Personal
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/diarioge/form_reporte_diario_tienda.php','#CapaContenedorFormulario')">
                                Reporte Diario
                            </a>
                        </span>
                        <br/>    
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productoge/form_reporte_producto.php','#CapaContenedorFormulario')">
                                Reporte Productos
                            </a>
                        </span>
                        <br/> 
                        <span class="foldertreeview">Registro de Informacion</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/vale/grid_vale.php','#CapaContenedorFormulario')">
                                Vales
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/canje/grid_canje.php','#CapaContenedorFormulario')">
                                Canjes
                            </a>
                        </span>
                        <br/>

                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/personal/grid_personal.php','#CapaContenedorFormulario')">
                                Descuento de Personal
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Mantenimiento</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productogestion/grid.php','#CapaContenedorFormulario')">
                                Gestionar Productos
                            </a>
                        </span>
                        <br/>  
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/ofertagestion/grid.php','#CapaContenedorFormulario')">
                                Gestionar Ofertas
                            </a>
                        </span>
                        <br/>     
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajerogestion/grid.php','#CapaContenedorFormulario')">
                                Gestionar Cajeros
                            </a>
                        </span>
                        <br/>  
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/meserogestion/grid.php','#CapaContenedorFormulario')">
                                Gestionar Meseros
                            </a>
                        </span>
                        <br/>  
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/categoriagestion/grid.php','#CapaContenedorFormulario')">
                                Gestionar Categoria
                            </a>
                        </span>
                        <br/> 
                        <span class="foldertreeview">Formulacion</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/Formulacion/inicio.php','#CapaContenedorFormulario')">
                                Formulacion
                            </a>
                        </span>
                        <br/> 
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/Formulacionp/inicio.php','#CapaContenedorFormulario')">
                                Proceso
                            </a>
                        </span>
                        <br>						
                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_sanisidro'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Caja San Isidro</h3>
                    <p>
                        <span class="foldertreeview">Depositos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajasi/new_deposito.php','#CapaContenedorFormulario')">
                                Ingresar Deposito
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajasi/grid_deposito.php','#CapaContenedorFormulario')">
                                Lista Depositos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Gasto Personal</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastosi/new_gasto.php','#CapaContenedorFormulario')">
                                Ingresar Consumo
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastosi/grid_gasto.php','#CapaContenedorFormulario')">
                                Lista de Consumos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/diariosi/form_reporte_diario_tienda.php','#CapaContenedorFormulario')">
                                Reporte Diario
                            </a>
                        </span>
                        <!--<br>
                                                <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/diariosi/form_reporte_diario_tienda2.php','#CapaContenedorFormulario')">
                                Prueba-noDarClick
                            </a>
                        </span>-->
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productosi/form_reporte_producto.php','#CapaContenedorFormulario')">
                                Reporte Productos
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/resumensi/form_reporte_resumen.php','#CapaContenedorFormulario')">
                                Resumen Productos
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsi/AlmacenInventarioFisicoForm.php','#CapaContenedorFormulario')">
                                Kardex Unidades Fisicas
                            </a>
                        </span>
                        <br/>

                        <?php if ($_SESSION['gTipoUsuario'] != 14) { ?>

                            <span class="foldertreeview">Adm. Horarios</span><br/>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmGrupo/view.php?idLocal=1','#CapaContenedorFormulario')">
                                    Gestion Personal
                                </a>
                            </span>
                            <br>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmHorario/view.php?idLocal=1','#CapaContenedorFormulario')">
                                    Gestion Horarios
                                </a>
                            </span>
                            <br/>
                        <?php } ?>
                        <span class="foldertreeview">Almacen</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsi/grid_registro_entrada.php','#CapaContenedorFormulario')">
                                Entradas
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsi/grid_registro_salida.php','#CapaContenedorFormulario')">
                                Salidas
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Procesos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsi/AlmacenCierreMesForm.php','#CapaContenedorFormulario')">
                                Cierre de mes</a>
                        </span>
                        <br>
                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_miraflores'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Caja Miraflores</h3>
                    <p>
                        <span class="foldertreeview">Depositos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajami/new_deposito.php','#CapaContenedorFormulario')">
                                Ingresar Deposito
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajami/grid_deposito.php','#CapaContenedorFormulario')">
                                Lista Depositos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Gasto Personal</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastomi/new_gasto.php','#CapaContenedorFormulario')">
                                Ingresar Consumo
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastomi/grid_gasto.php','#CapaContenedorFormulario')">
                                Lista de Consumos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/diariomi/form_reporte_diario_tienda.php','#CapaContenedorFormulario')">
                                Reporte Diario
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productomi/form_reporte_producto.php','#CapaContenedorFormulario')">
                                Reporte Productos
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/resumenmi/form_reporte_resumen.php','#CapaContenedorFormulario')">
                                Resumen Productos
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almmi/AlmacenInventarioFisicoForm.php','#CapaContenedorFormulario')">
                                Kardex Unidades Fisicas
                            </a>
                        </span>
                        <br/>

                        <?php if ($_SESSION['gTipoUsuario'] != 15) { ?>
                            <span class="foldertreeview">Adm. Horarios</span><br/>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmGrupo/view.php?idLocal=2','#CapaContenedorFormulario')">
                                    Gestion Personal
                                </a>
                            </span>
                            <br>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmHorario/view.php?idLocal=2','#CapaContenedorFormulario')">
                                    Gestion Horarios
                                </a>
                            </span>
                            <br/>
                        <?php } ?>
                        <span class="foldertreeview">Almacen</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almmi/grid_registro_entrada.php','#CapaContenedorFormulario')">
                                Entradas
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almmi/grid_registro_salida.php','#CapaContenedorFormulario')">
                                Salidas
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Procesos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almmi/AlmacenCierreMesForm.php','#CapaContenedorFormulario')">
                                Cierre de mes</a>
                        </span>
                        <br/>
                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_sanborja'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Caja San Borja</h3>
                    <p>
                        <span class="foldertreeview">Depositos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajasb/new_deposito.php','#CapaContenedorFormulario')">
                                Ingresar Deposito
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajasb/grid_deposito.php','#CapaContenedorFormulario')">
                                Lista Depositos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Gasto Personal</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastosb/new_gasto.php','#CapaContenedorFormulario')">
                                Ingresar Consumo
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastosb/grid_gasto.php','#CapaContenedorFormulario')">
                                Lista de Consumos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/diariosb/form_reporte_diario_tienda.php','#CapaContenedorFormulario')">
                                Reporte Diario
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productosb/form_reporte_producto.php','#CapaContenedorFormulario')">
                                Reporte Productos
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/resumensb/form_reporte_resumen.php','#CapaContenedorFormulario')">
                                Resumen Productos
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsb/AlmacenInventarioFisicoForm.php','#CapaContenedorFormulario')">
                                Kardex Unidades Fisicas
                            </a>
                        </span>
                        <br/>

                        <?php if ($_SESSION['gTipoUsuario'] != 16) { ?>		   
                            <span class="foldertreeview">Adm. Horarios</span><br/>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmGrupo/view.php?idLocal=3','#CapaContenedorFormulario')">
                                    Gestion Personal
                                </a>
                            </span>
                            <br>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmHorario/view.php?idLocal=3','#CapaContenedorFormulario')">
                                    Gestion Horarios
                                </a>
                            </span>
                            <br/>
                        <?php } ?>
                        <span class="foldertreeview">Almacen</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsb/grid_registro_entrada.php','#CapaContenedorFormulario')">
                                Entradas
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsb/grid_registro_salida.php','#CapaContenedorFormulario')">
                                Salidas
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Procesos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almsb/AlmacenCierreMesForm.php','#CapaContenedorFormulario')">
                                Cierre de mes</a>
                        </span>
                        <br/>
                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_pueblolibre'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Caja Pueblo Libre</h3>
                    <p>
                        <span class="foldertreeview">Depositos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajapl/new_deposito.php','#CapaContenedorFormulario')">
                                Ingresar Deposito
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/cajapl/grid_deposito.php','#CapaContenedorFormulario')">
                                Lista Depositos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Gasto Personal</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastopl/new_gasto.php','#CapaContenedorFormulario')">
                                Ingresar Consumo
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/gastopl/grid_gasto.php','#CapaContenedorFormulario')">
                                Lista de Consumos
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/diariopl/form_reporte_diario_tienda.php','#CapaContenedorFormulario')">
                                Reporte Diario
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productopl/form_reporte_producto.php','#CapaContenedorFormulario')">
                                Reporte Productos
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/resumenpl/form_reporte_resumen.php','#CapaContenedorFormulario')">
                                Resumen Productos
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almpl/AlmacenInventarioFisicoForm.php','#CapaContenedorFormulario')">
                                Kardex Unidades Fisicas
                            </a>
                        </span>
                        <br/>								
                        <?php if ($_SESSION['gTipoUsuario'] != 17) { ?>
                            <span class="foldertreeview">Adm. Horarios</span><br/>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmGrupo/view.php?idLocal=4','#CapaContenedorFormulario')">
                                    Gestion Personal
                                </a>
                            </span>
                            <br>
                            <span class="icn1">
                                <a class="linka1" href="javascript:cargar_pagina('personal/AdmHorario/view.php?idLocal=4','#CapaContenedorFormulario')">
                                    Gestion Horarios
                                </a>
                            </span>
                            <br/>
                        <?php } ?>
                        <span class="foldertreeview">Almacen</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almpl/grid_registro_entrada.php','#CapaContenedorFormulario')">
                                Entradas
                            </a>
                        </span>
                        <br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almpl/grid_registro_salida.php','#CapaContenedorFormulario')">
                                Salidas
                            </a>
                        </span>
                        <br/>
                        <span class="foldertreeview">Procesos</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('Almpl/AlmacenCierreMesForm.php','#CapaContenedorFormulario')">
                                Cierre de mes</a>
                        </span>
                        <br/>
                        <br/>
                    </p>
                <?php } ?>

                <?php if ($_SESSION['acceso_gerencia'] == 'false') { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">Gerencia</h3>
                    <p>
                        <span class="foldertreeview">Reportes</span><br/>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/form_reporte_diario.php','#CapaContenedorFormulario')">
                                Reporte Diario
                            </a>
                        </span>
                        <br>

                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/form_reporte_mes.php','#CapaContenedorFormulario')">
                                Resumen de Ventas
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/form_reporte_vtames.php','#CapaContenedorFormulario')">
                                Ventas - SUNAT
                            </a>
                        </span>
                        <br>
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/form_reporte_diario_tienda.php','#CapaContenedorFormulario')">
                                R. Diario x Tienda
                            </a>
                        </span>
                        <br>                    
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productoge/form_reporte_producto.php','#CapaContenedorFormulario')">
                                Productos por Tienda
                            </a>
                        </span>
                        <br>                    
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('caja/productoge/form_reporte_producto_fechas.php','#CapaContenedorFormulario')">
                                Productos por Tienda(2)
                            </a>
                        </span>
                        <br/> 
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('gerencia/form_producto_pedido.php','#CapaContenedorFormulario')">
                                Productos por Pedidos
                            </a>
                        </span>
                        <br/> 
                    </p>
                <?php } ?>

                    
                    
                <!-- 
                //Editado : 03/05/2012
                //Anibal Copitan Norabuena
                -->
                <?php if (/* $_SESSION['acceso_activos'] == 'false' */ true) { ?>
                    <h3 class="text_blanco" style="color:#FFFFFF">SUNAT T-REGISTRO</h3>
                    <p>
                        <span class="foldertreeview">T-Registro</span><br/>						
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/view_empleador.php','#CapaContenedorFormulario')">
                                Empleador
                            </a>
                        </span>
                        <br /><!--
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/view_establecimiento.php','#CapaContenedorFormulario')">
                                Emp Establecimientos
                            </a>
                        </span>
                        <br />	-->
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/view_personal.php','#CapaContenedorFormulario')">
                                Personal
                            </a>
                        </span>
                        <br />
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/view_derechohabiente.php','#CapaContenedorFormulario')">
                                DerechoHabientes
                            </a>
                        </span>
                        
                        <br />
                       <span class="foldertreeview">T-Registro Estructuras</span><br/>						
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/estructuras/trabajador.php','#CapaContenedorFormulario')">
                                Trabajador
                            </a>
                        </span>
                        <br />
                        
                        <!--
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/view_establecimiento.php','#CapaContenedorFormulario')">
                                Emp Establecimientos
                            </a>
                        </span>
                        <br />	-->
                        
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view/estructuras/index.php','#CapaContenedorFormulario')">
                                Exportar Archivos
                            </a>
                        </span>
                        <br />
                        
                    <h3 class="text_blanco" style="color:#FFFFFF">SUNAT PDT-PLAME</h3>
                    <p>
                        <span class="foldertreeview">Empleador</span><br/>						
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view-plame/view_empleador.php','#CapaContenedorFormulario')">
                                Modificar
                            </a>
                        </span>
                        <br />
                       
                        
                        <span class="foldertreeview">Declaraciones Juradas</span><br/>						
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view-plame/new_declaracion.php','#CapaContenedorFormulario')">
                                Nueva Declaracion
                            </a>
                        </span>
                        <br />
                        
                        <span class="icn1">
                            <a class="linka1" href="javascript:cargar_pagina('sunat_planilla/view-plame/view_declaracion_registrada.php','#CapaContenedorFormulario')">
                                Declaraciones Registradas
                            </a>
                        </span>
                        <br />                        
                        
                        
                        
                    <?php } ?>
                </p>




</div>







            <?php if ($_SESSION['acceso_gerencia'] == 'false') { ?>
                <div id="CapaContenedorFormulario" style="overflow:scroll; height:610px;"></div>
            <?php } else { ?>
                <div id="CapaContenedorFormulario" style="overflow:scroll; height:610px;"></div>
            <?php } ?>

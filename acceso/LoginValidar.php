<?php

session_start();

include("../class/Class.Login.Prosic.php");
sleep(4);
$objIniciarLogin = new Login_Prosic();
$validar = $objIniciarLogin->existe_usuario($_POST['email_usuario']);

if ($validar != 0 && $objIniciarLogin->getStatusUsuario() == "A") {
    $validar2 = $objIniciarLogin->iniciarSesionUsuario($_POST['email_usuario'], md5($_POST['password_usuario']), $_POST['id_empresa']);
    if ($validar2 != 0 && $objIniciarLogin->getStatusUsuario() == "A") {
        $_SESSION['gIdUsuario'] = $objIniciarLogin->getIdUsuario();
        $_SESSION['gNombreUsuario'] = $objIniciarLogin->getNombreUsuario();
        $_SESSION['gTipoUsuario'] = $objIniciarLogin->getTipoUsuario();
        $_SESSION['gRucEmpresa'] = $objIniciarLogin->getRucEmpresa();
        $_SESSION['gNombreEmpresa'] = $objIniciarLogin->getNombreEmpresa();

        $result_perfil = $objIniciarLogin->get_perfil_usuario();
        while ($row = mysql_fetch_assoc($result_perfil)) {
            switch ($row['id_modulo']) {
                case 1 : $_SESSION['acceso_almacen'] = $row['privilegio_modulo'];
                    break;
                case 2 : $_SESSION['acceso_activos'] = $row['privilegio_modulo'];
                    break;
                case 3 : $_SESSION['acceso_planillas'] = $row['privilegio_modulo'];
                    break;
                case 4 : $_SESSION['acceso_contabilidad'] = $row['privilegio_modulo'];
                    break;
                case 5 : $_SESSION['acceso_produccion'] = $row['privilegio_modulo'];
                    break;
                case 6 : $_SESSION['acceso_costos'] = $row['privilegio_modulo'];
                    break;
                case 7 : $_SESSION['acceso_caja'] = $row['privilegio_modulo'];
                    break;
                case 8 : $_SESSION['acceso_tesoreria'] = $row['privilegio_modulo'];
                    break;
                case 9 : $_SESSION['acceso_seguridad'] = $row['privilegio_modulo'];
                    break;
                case 10 : $_SESSION['acceso_sistema'] = $row['privilegio_modulo'];
                    break;
                case 11 : $_SESSION['acceso_gerencia'] = $row['privilegio_modulo'];
                    break;
                case 12 : $_SESSION['acceso_utilitarios'] = $row['privilegio_modulo'];
                    break;
                case 13 : $_SESSION['acceso_sanisidro'] = $row['privilegio_modulo'];
                    break;
                case 14 : $_SESSION['acceso_miraflores'] = $row['privilegio_modulo'];
                    break;
                case 15 : $_SESSION['acceso_sanborja'] = $row['privilegio_modulo'];
                    break;
                case 16 : $_SESSION['acceso_pueblolibre'] = $row['privilegio_modulo'];
                    break;
                case 17 : $_SESSION['acceso_cajageneral'] = $row['privilegio_modulo'];
                    break;
            }
        }
        header('location: ../index.php');
    } else {
        header('location: login.php?r=e');
    }
} elseif ($validar != 0 && $objIniciarLogin->getStatusUsuario() == "N") {
    header('location: nuevo_password.php?email_usuario=' . $_POST['email_usuario']);
} elseif ($validar != 0 && $objIniciarLogin->getStatusUsuario() == "B") {
    header('location: login.php?r=b');
} else {
    header('location: login.php?r=e');
}
?>
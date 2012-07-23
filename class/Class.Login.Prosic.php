<?php

include_once('Class.Mysql.Prosic.php');

class Login_Prosic extends Mysql_Prosic {

    private $IdUsuario = "";
    private $NombreUsuario = "";
    private $EmailUsuario = "";
    private $IdEmpresa = "";
    private $NombreEmpresa = "";
    private $RucEmpresa = "";
    private $TipoUsuario = "";
    private $StatusUsuario = "";

    function existe_usuario($email_usuario) {
        $sql = "select * from prosic_usuario where email_usuario='" . $email_usuario . "'";
        $rsLogin = $this->Consulta_Mysql($sql);
        $rowLogin = mysql_fetch_assoc($rsLogin);
        $this->setStatusUsuario($rowLogin['status_usuario']);
        $countLogin = mysql_num_rows($rsLogin);
        return $countLogin;
    }

    function iniciarSesionUsuario($email, $password, $empresa) {
        $query = "SELECT
    				prosic_empresa.nombre_empresa
    				, prosic_empresa.ruc_empresa
				    , prosic_empresa.id_empresa
					, prosic_usuario.nombre_usuario
					, prosic_usuario.password_usuario
					, prosic_usuario.id_tipo_usuario
					, prosic_usuario.status_usuario
					, prosic_usuario.email_usuario
					, prosic_usuario.id_usuario
					FROM
					dbprosic.prosic_usuario
					INNER JOIN dbprosic.prosic_empresa
					ON (prosic_usuario.id_empresa = prosic_empresa.id_empresa)
					WHERE	prosic_usuario.email_usuario = '" . $email . "'
						  AND 	prosic_usuario.password_usuario='" . $password . "'
						  AND	prosic_usuario.id_empresa=" . $empresa;

        $rsLogin = $this->Consulta_Mysql($query);

        $rowLogin = mysql_fetch_assoc($rsLogin);

        $this->setIdUsuario($rowLogin['id_usuario']);
        $this->setNombreUsuario($rowLogin['nombre_usuario']);
        $this->setEmailUsuario($rowLogin['email_usuario']);
        $this->setIdEmpresa($rowLogin['id_empresa']);
        $this->setRucEmpresa($rowLogin['ruc_empresa']);
        $this->setNombreEmpresa($rowLogin['nombre_empresa']);
        $this->setTipoUsuario($rowLogin['id_tipo_usuario']);
        $this->setStatusUsuario($rowLogin['status_usuario']);

        $countLogin = mysql_num_rows($rsLogin);

        return $countLogin;
    }

    function setIdUsuario($valor) {
        $this->IdUsuario = $valor;
    }

    function getIdUsuario() {
        return $this->IdUsuario;
    }

    function setNombreUsuario($valor) {
        $this->NombreUsuario = $valor;
    }

    function getNombreUsuario() {
        return $this->NombreUsuario;
    }

    function setEmailUsuario($valor) {
        $this->EmailUsuario = $valor;
    }

    function getEmailUsuario() {
        return $this->EmailUsuario;
    }

    function setIdEmpresa($valor) {
        $this->IdEmpresa = $valor;
    }

    function getIdEmpresa() {
        return $this->IdEmpresa;
    }

    function setNombreEmpresa($valor) {
        $this->NombreEmpresa = $valor;
    }

    function getNombreEmpresa() {
        return $this->NombreEmpresa;
    }

    function setRucEmpresa($valor) {
        $this->RucEmpresa = $valor;
    }

    function getRucEmpresa() {
        return $this->RucEmpresa;
    }

    function setTipoUsuario($valor) {
        $this->TipoUsuario = $valor;
    }

    function getTipoUsuario() {
        return $this->TipoUsuario;
    }

    function setStatusUsuario($valor) {
        $this->StatusUsuario = $valor;
    }

    function getStatusUsuario() {
        return $this->StatusUsuario;
    }

    function get_perfil_usuario() {
        $sql = "SELECT * FROM prosic_acceso_modulo WHERE prosic_acceso_modulo.id_tipo_usuario=" . $this->getTipoUsuario();
        $return = $this->Consulta_Mysql($sql);
        return $return;
    }

}

?>
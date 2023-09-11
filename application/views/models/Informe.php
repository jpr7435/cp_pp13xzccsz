<?php

/*
 * AES_DECRYPT(documento, 'S1cc0l2017!!')
 *
 * $this -> config -> item('empresa')
 *
 *
 * AES_ENCRYPT('$doc', 'S1cc0l2017!!')
 */

class Informe extends CI_Model {

    private $key;

    public function __construct() {
        $this->key = $this->config->item('encript');
    }

    public function savequery($consulta, $event, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = str_replace("'", "", $consulta);

        $query = $this->db->query("update 16_logEventos set query = '$consulta' where idLog = '$event'");

    }

    public function getAllIp() {
        $query = $this->db->query("select * from autorizacion");
        return $query->result_array();
    }



    public function getusuario($id) {

        $this->db = $this->load->database('users', TRUE);

        if ($id == 0) {
            return $data = array("0" => array("nombre" => "Sin Asesor"));
        } else {
            $query = $this->db->query("select * from usuarios where idUsuario = '$id'");
            return $query->result_array();
        }
    }



    public function getInventarios($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from inventarios order by idInventario asc  limit 0, 500;");
        return $query->result_array();
    }
    
    public function getPagosTot($data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(identificacion,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from pagos order by fecha asc;");
        return $query->result_array();
    }
    
    public function getGestionesMes($fechaInicial, $fechaActual, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select *, AES_DECRYPT(documento,  '$this->key') as documento from 7_callhist where fechaGestion >= '$fechaInicial' and fechaGestion <= '$fechaActual' order by idCallhist asc;");
        return $query->result_array();
    }
    
    public function getModalidad($pr, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select modalidad from 51_tipoProducto where tipo = '$pr';");
        return $query->result_array();
    }

    public function getCliente($doc, $data) {

        $this->db = $this->load->database($data, TRUE);

        $consulta = "select *, AES_DECRYPT(documento,  '$this->key') as documento from 10_clientes where documento = AES_ENCRYPT('$doc', '$this->key');";

        $query = $this->db->query($consulta);
        return $query->result_array();
    }

    public function getCredito($oh, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select producto, activo, diasMora, fechaApertura, saldoACapital, saldoTotal, capitalEnMora, saldoMora, AES_DECRYPT(documento,  '$this->key') as documento, AES_DECRYPT(obligacion,  '$this->key') as obligacion from 9_creditos where obligacion = AES_ENCRYPT('$oh',  '$this->key');");
        return $query->result_array();
    }

    public function getMarcaOh($oh, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("select date_defined6, nuip, radicado from marcasObligacion where radicado = '$oh';");
        return $query->result_array();
    }

    public function getDiasGest($doc, $dia, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("SELECT EXTRACT(DAY FROM fechaGestion) as dia, count(documento) as doc FROM 7_callhist WHERE fechaGestion > '$dia' and documento = AES_ENCRYPT('$doc', '$this->key') group by dia;");
        return $query->result_array();
    }
    
    public function getSegmento($mod, $dias, $data) {

        $this->db = $this->load->database($data, TRUE);
        
       // echo "select * from 52_franjas where producto = '$mod' and desde >= '$dias' and hasta <= '$dias';";
        $query = $this->db->query("select * from 52_franjas where producto = '$mod' and desde <= '$dias' and hasta >= '$dias';");
        return $query->result_array();
    }
    
    public function getDesasignaciones($oh, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select * from desasignaciones where radicado = '$oh';");
        return $query->result_array();
    }
    
    public function getNivelDesg($causa, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select * from 53_causas where causa = '$causa';");
        return $query->result_array();
    }
    
    public function getMaxPromesa($oh, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select max(idPromesa) as maximo from 6_promesas where obligacion = AES_ENCRYPT('$oh', '$this->key');");
        return $query->result_array();
    }
    
    public function getPromesa($id, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select fechaPromesa, valorpromesa, idCumplido from 6_promesas where idPromesa = '$id';");
        return $query->result_array();
    }
    
    
    public function getMotivo($id, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select * from 3_motivos_no_pago where idMotivo = '$id';");
        return $query->result_array();
    }
    
    public function getContacto($id, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select * from 2_contacto where idContacto = '$id';");
        return $query->result_array();
    }
    
    public function getResultado($id, $data) {

        $this->db = $this->load->database($data, TRUE);
        
        $query = $this->db->query("select * from 4_resultado where idCodres = '$id';");
        return $query->result_array();
    }
    
    public function updateIntentosMes($doc, $valor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set intentosParcial = '$valor' where nuip = '$doc';");

    }

    public function updateCtaClientes($oh, $valor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set ctaClientes = '$valor' where radicado = '$oh';");

    }
    
    public function updateMaxFecPago($oh, $valor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set fechaPago = '$valor' where radicado = '$oh';");

    }
    
    public function updateMotivos($doc, $motivo, $fecha, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set motivoNoPago = '$motivo', fechaMotivo = '$fecha' where nuip = '$doc';");

    }
    
    public function updateTotPago($oh, $valor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set valorPago = '$valor' where radicado = '$oh';");

    }
    
    public function updateTotPagoMes($oh, $valor, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set pagosMes = '$valor' where radicado = '$oh';");

    }
    
    public function updateMenorDeg($doc, $causa, $data) {

        $this->db = $this->load->database($data, TRUE);


        $query = $this->db->query("update 50_informe_general set minCausaEstado = '$causa' where radicado = '$doc';");

    }
    
    public function updatePrContacto($doc, $id, $data) {

        $this->db = $this->load->database($data, TRUE);


        $query = $this->db->query("update 50_informe_general set primerContacto = '$id' where nuip = '$doc';");

    }
    
    public function updatePrResultado($doc, $id, $data) {

        $this->db = $this->load->database($data, TRUE);


        $query = $this->db->query("update 50_informe_general set primerEfecto = '$id' where nuip = '$doc';");

    }
    
    
    public function updateUlContacto($doc, $id, $data) {

        $this->db = $this->load->database($data, TRUE);


        $query = $this->db->query("update 50_informe_general set ultimoContacto = '$id' where nuip = '$doc';");

    }
    
    public function updateUlResultado($doc, $id, $data) {

        $this->db = $this->load->database($data, TRUE);


        $query = $this->db->query("update 50_informe_general set ultimoEfecto = '$id' where nuip = '$doc';");

    }

    public function updateAceleClientes($doc, $valor, $data) {

        $this->db = $this->load->database($data, TRUE);


        $query = $this->db->query("update 50_informe_general set titAcelerado = '$valor' where nuip = '$doc';");

    }

    public function updatePareto($doc, $pareto, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set saldoPareto = '$pareto' where nuip = '$doc';");

    }
    
    public function updateFranjaPareto($doc, $pareto, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("update 50_informe_general set cabezaMora = '$pareto' where nuip = '$doc';");

    }

    public function saveInforme($doc, $nombre, $bini, $oh, $cartera, $sexo, $grupo, $ciudad, $pr, $modalidad, $segmentoIni, $activo, $fasigna, $fdesasig, $dmoraini, $dmora, $franjaIni, $franjaCre, $fecnac, $fecApe, $capiIni, $capi, $capiCierre, $satot, $capimora, $salmora, $fecprox, $fecUltima, $difDiasGest, $fechaProm, $valorProm, $estadoProm, $acelerado, $fcastigo, $diasAsig, $diasGest, $usuario, $nombre, $data) {

        $this->db = $this->load->database($data, TRUE);

        $query = $this->db->query("insert into 50_informe_general (nuip, nombre, baseInicial, radicado, cartera, sexo, grupo, ciudad, producto, modalidad, segmentoInicial, activo, fechaAsignacion, fechaDesasignacion, dmoraIni, diasMora, franjaInicial, franja, fechaNacimiento, fechaApertura, capitalInicial, saldoAcapital, capitalCierre, saldoTotal, capitalEnMora, saldoMora, fechaProximaAccion, fechaUltimaGestion, difProxUlt, fechaPromesa, valorCancelar, estadoPromesa, acelerado, fchCastigo, diasAsignado, diasGesParcial, usuario, nombreUsuario)
                                                          values ('$doc', '$nombre', '$bini', '$oh', '$cartera', '$sexo', '$grupo', '$ciudad', '$pr', '$modalidad', '$segmentoIni', '$activo', '$fasigna', '$fdesasig', '$dmoraini', '$dmora', '$franjaIni', '$franjaCre', '$fecnac', '$fecApe', '$capiIni', '$capi', '$capiCierre', '$satot', '$capimora', '$salmora', '$fecprox', '$fecUltima', '$difDiasGest', '$fechaProm', '$valorProm', '$estadoProm', '$acelerado', '$fcastigo', '$diasAsig', '$diasGest', '$usuario', '$nombre');");
    }

}

?>

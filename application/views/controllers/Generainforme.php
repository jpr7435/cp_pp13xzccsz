<?php
set_time_limit(900);
class Generainforme extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Informe');
        $this->load->library('session');
        $this->load->library('utilidades');
    }

    public function restarFechas($fechaMenor, $fechaMayor){
      $date1 = new DateTime($fechaMenor);
      $date2 = new DateTime($fechaMayor);
      $diff = $date1->diff($date2);
      // will output 2 days
      return $diff->days;
    }
    
    public function restarFechasRestar($fechaAntigua, $hoy) {

            $segundos = strtotime($hoy) - strtotime($fechaAntigua);
            $diferencia = intval($segundos / 60 / 60 / 24);

            return $diferencia;
    }

    public function generaInforme() {
        
        
        $fechaActual = date("Y-m-d H:i:s");
        $fechaActualDia = date("Y-m-d");
        $fechaInicial = date("Y-m")."-01 ".date("H:i:s");

        $inventarios = $this->Informe->getInventarios('bcsc');
        $gestionesMes = $this->Informe->getGestionesMes($fechaInicial, $fechaActual, 'bcsc');
        $pagosTotales = $this->Informe->getPagosTot('bcsc');
        
        $paretos = "";
        $ctaclientes = "";
        $acelerado = "";
        $aceleradotit = "";
        $franjaPareto = "";
        $capicierre = 0;
        $menorDesg = "";
        $f = 0;
        foreach($inventarios as $inve){
          $acelerado = "No";
          $clientes = $this->Informe->getCliente($inve['documento'], 'bcsc');
          $creditos = $this->Informe->getCredito($inve['obligacion'], 'bcsc');
          $marcaoh = $this->Informe->getMarcaOh($inve['obligacion'], 'bcsc');
          $asesores = $this->Informe->getusuario($clientes[0]['idAsesor'], 'bcsc');
          
          
          $fechaProm = "";
          $valorProm = "";
          $estadoProm = "";

          $cartera = "No Castigo";
          if($inve['fch_castigo'] != ''){
            $cartera = "Castigo";
          }

          $fasignaPart = explode("-", $inve['fch_asignacion']);
          $bini = "";
          if($fasignaPart[2] == "01"){
            $bini = "Inicio";
          }


          if($creditos[0]['activo'] == 1){

            if(isset($paretos[$inve['documento']])){
              $paretos[$inve['documento']] = $paretos[$inve['documento']] + $creditos[0]['saldoACapital'];
            }else{
              $paretos[$inve['documento']] = $creditos[0]['saldoACapital'];
            }

            if(isset($ctaclientes[$inve['documento']])){
              if($ctaclientes[$inve['documento']]['diasmora'] <= $creditos[0]['diasMora']){

                $ctaclientes[$inve['documento']]['diasmora'] =  $creditos[0]['diasMora'];
                $ctaclientes[$inve['documento']]['obligacion'] =  $creditos[0]['obligacion'];
              }
            }else{
              $ctaclientes[$inve['documento']]['diasmora'] =  $creditos[0]['diasMora'];
              $ctaclientes[$inve['documento']]['obligacion'] =  $creditos[0]['obligacion'];
            }

          }
          if(isset($marcaoh[0]['date_defined6'])){
            if($marcaoh[0]['date_defined6'] != ""){
              $acelerado = "Si";
              $aceleradotit[$f] = $inve['documento'];
              $f += 1;
            }
          }
          $hoy = date("Y-m-d");
          $iniMes = date("Y-m")."-01";
          $diasAsignado = $this->restarFechas($inve['fch_asignacion'], $hoy);


          $fecnac = explode(" ", $clientes[0]['fechaNacimiento']);
          $proxacc = explode(" ", $clientes[0]['fechaProximaAccion']);

          //SELECT EXTRACT(DAY FROM fechaGestion) as dia, count(documento) as doc FROM `7_callhist` WHERE fechaGestion > '2019-02-01' and documento = AES_ENCRYPT('C1001024604','4nd3rsV4g45') group by dia;



          $gestParc =  $this->Informe->getDiasGest($inve['documento'], $iniMes, 'bcsc');

          $diasGest = count($gestParc);
          
          $modalidad = $this->Informe->getModalidad($creditos[0]['producto'], 'bcsc');
          
           //$modalidad[0]['modalidad'];
          $preSegIni = $this->Informe->getSegmento($modalidad[0]['modalidad'], $inve['dmora_ini'], 'bcsc');
          $maxIdProm = $this->Informe->getMaxPromesa($inve['obligacion'], 'bcsc');
          if(isset($maxIdProm[0]['maximo'])){
            $maxProm = $this->Informe->getPromesa($maxIdProm[0]['maximo'], 'bcsc');
              
            $fechaProm = $maxProm[0]['fechaPromesa'];
            $valorProm = $maxProm[0]['valorpromesa'];
            $estadoProm = $maxProm[0]['idCumplido'];;
          }else{
            $fechaProm = "";
            $valorProm = "";
            $estadoProm = "";
          }
          
          
          
          
          $franjaCre = $this->Informe->getSegmento($modalidad[0]['modalidad'], $creditos[0]['diasMora'], 'bcsc');
          
          $desasignaciones = $this->Informe->getDesasignaciones($creditos[0]['obligacion'], 'bcsc');
          
           if(isset($desasignaciones[0]['causaEstado'])){
              
               $nivelDesg = $this->Informe->getNivelDesg($desasignaciones[0]['causaEstado'], 'bcsc');
               
               if(isset($menorDesg[$inve['obligacion']])){
                  
                   if($nivelDesg[0]['idCausa'] < $menorDesg[$inve['obligacion']]['nivel']){
                        $menorDesg[$inve['obligacion']]['nivel'] = $nivelDesg[0]['idCausa'];
                        $menorDesg[$inve['obligacion']]['causa'] = $nivelDesg[0]['causa'];
                        
                   } 
               }else{
                   $menorDesg[$inve['obligacion']]['nivel'] = $nivelDesg[0]['idCausa'];
                   $menorDesg[$inve['obligacion']]['causa'] = $nivelDesg[0]['causa'];
               }
               
              if($desasignaciones[0]['causaEstado'] == "NORMALIZADO"){
                  $capicierre = 0;
              }else if($desasignaciones[0]['causaEstado'] == "CANCELADO"){
                  $capicierre = 0;
              }else{
                  $capicierre = $creditos[0]['saldoACapital'];
              } 
           }else{
               $capicierre = $creditos[0]['saldoACapital'];
           }
           
           
          
          if(isset($franjaPareto[$inve['documento']])){
               if($franjaCre[0]['franja_cabeza'] < $franjaPareto[$inve['documento']]){
                 $franjaPareto[$inve['documento']] = $franjaCre[0]['franja_cabeza'];
               }
          }else{
              $franjaPareto[$inve['documento']] = $franjaCre[0]['franja_cabeza'];
          }
          
          $preProxBien = explode("/", $proxacc[0]);
          $ProxBien = $preProxBien[2]."-".$preProxBien[1]."-".$preProxBien[0];
          
          $difDiasGest = $this->restarFechas($ProxBien, $clientes[0]['FecUltimaGestion']);
          
          $this->Informe->saveInforme($inve['documento'], $clientes[0]['nombre'], $bini, $creditos[0]['obligacion'], $cartera, $clientes[0]['sexo'], $clientes[0]['grupo'], $clientes[0]['ciudad'], $creditos[0]['producto'], $modalidad[0]['modalidad'],
          $preSegIni[0]['franjaBanco'], $creditos[0]['activo'], $inve['fch_asignacion'], $inve['fch_desasignacion'], $inve['dmora_ini'], $creditos[0]['diasMora'], $preSegIni[0]['franja_cabeza'], $franjaCre[0]['franja_cabeza'], $fecnac[0], $creditos[0]['fechaApertura'], $inve['capital_inicial'], $creditos[0]['saldoACapital'],
          $capicierre, $creditos[0]['saldoTotal'], $creditos[0]['capitalEnMora'], $creditos[0]['saldoMora'], $proxacc[0], $clientes[0]['FecUltimaGestion'], $difDiasGest, $fechaProm, $valorProm, $estadoProm, $acelerado, $inve['fch_castigo'], $diasAsignado, $diasGest,
          $asesores[0]['usuario'], $asesores[0]['nombre'], 'bcsc');




        }//Cierre Foreach Inventarios
          
          $intentosMes = "";
          $primerResultado = "";
          $primerContacto = "";
          $ultimoResultado = "";
          $ultimoContacto = "";
          $ultimoMotivo = "";
          $ultimoMotivoFec = "";
          
          foreach($gestionesMes as $gesMes){
             if(isset($intentosMes[$gesMes['documento']])){
                 $intentosMes[$gesMes['documento']] += 1;
                 $ultimoResultado[$gesMes['documento']] = $gesMes['idResultado'];
                 $ultimoContacto[$gesMes['documento']] = $gesMes['idContacto'];
             }else{
                 $intentosMes[$gesMes['documento']] = 1;
                 $primerResultado[$gesMes['documento']] = $gesMes['idResultado'];
                 $primerContacto[$gesMes['documento']] = $gesMes['idContacto'];
                 $ultimoResultado[$gesMes['documento']] = $gesMes['idResultado'];
                 $ultimoContacto[$gesMes['documento']] = $gesMes['idContacto'];
             }
               if($gesMes['idMotivo'] != 0){
                $ultimoMotivo[$gesMes['documento']] = $gesMes['idMotivo'];
                $fecGestSola = explode(" ",  $gesMes['fechaGestion']);
                $ultimoMotivoFec[$gesMes['documento']] = $fecGestSola[0];
               } 
                
          }
          
          foreach($ultimoMotivo as $key => $value){
            $motiv = $this->Informe->getMotivo($value, 'bcsc');
            if(!$motiv[0]['descripcion']){
                $motiv[0]['descripcion'] = "Sin Motivo";
            }
            $this->Informe->updateMotivos($key, $motiv[0]['descripcion'], $ultimoMotivoFec[$key], 'bcsc');
          }
          
          foreach($intentosMes as $key => $value){

            $this->Informe->updateIntentosMes($key, $value, 'bcsc');
          }
        
          foreach($paretos as $key => $value){

            $this->Informe->updatePareto($key, $value, 'bcsc');
          }

          foreach($ctaclientes as $cl1){

            $this->Informe->updateCtaClientes($cl1['obligacion'], "1", 'bcsc');
          }

          foreach($aceleradotit as $key => $value){

            $this->Informe->updateAceleClientes($value, "1", 'bcsc');
          }
          
          foreach($franjaPareto as $key => $value){

            $this->Informe->updateFranjaPareto($key, $value, 'bcsc');
          }
          foreach($menorDesg as $key => $value){
            $this->Informe->updateMenorDeg($key, $value['causa'], 'bcsc');
          }
          
          foreach($primerContacto as $key => $value){
            $cont1 = $this->Informe->getContacto($value, 'bcsc');  
            $this->Informe->updatePrContacto($key, $cont1[0]['descripcion'], 'bcsc');
          }
          
          foreach($primerResultado as $key => $value){
            $res1 = $this->Informe->getResultado($value, 'bcsc');
            $this->Informe->updatePrResultado($key, $res1[0]['descripcion'], 'bcsc');
          }
          
          foreach($ultimoContacto as $key => $value){
            $cont2 = $this->Informe->getContacto($value, 'bcsc');
            $this->Informe->updateUlContacto($key, $cont1[0]['descripcion'], 'bcsc');
          }
          
          foreach($ultimoResultado as $key => $value){
            $res2 = $this->Informe->getResultado($value, 'bcsc');
            $this->Informe->updateUlResultado($key, $res2[0]['descripcion'], 'bcsc');
          }
          
          $maxfecpago = "";
          $totpagos = "";
          $pagosMes = "";
          

          foreach($pagosTotales as $ptot){
              
              $unos = explode(" ", $ptot['fecha']);
              $prePagTotFec = explode("/", $unos[0]);
              $pagTotFec = $prePagTotFec[2]."-".$prePagTotFec[1]."-".$prePagTotFec[0];
              $mesActual = date("m");
              
              
              if(isset($totpagos[$ptot['obligacion']])){
                  $totpagos[$ptot['obligacion']] += $ptot['valor'];
              }else{
                  $totpagos[$ptot['obligacion']] = $ptot['valor'];
              }
              $maxfecpago[$ptot['obligacion']] = $pagTotFec;
              
              
              if($prePagTotFec[1] == $mesActual){
                  if(isset($pagosMes[$ptot['obligacion']])){
                      $pagosMes[$ptot['obligacion']] += $ptot['valor'];
                  }else{
                      $pagosMes[$ptot['obligacion']] = $ptot['valor'];
                  }
                  
                  
              }
          }
          
          foreach($maxfecpago as $key => $value){
            
            $this->Informe->updateMaxFecPago($key, $value, 'bcsc');
          }
          
          foreach($totpagos as $key => $value){
            
            $this->Informe->updateTotPago($key, $value, 'bcsc');
          }
          
          foreach($pagosMes as $key => $value){
            
            $this->Informe->updateTotPagoMes($key, $value, 'bcsc');
          }
       

          die();
    }


}

?>

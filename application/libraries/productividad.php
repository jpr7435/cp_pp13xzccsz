<?php

// Notificar todos los errores de PHP
error_reporting(1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class productividad {

    function export($asesor, $idcasa, $fechaini, $fechafin, $nameproyect) {

        $ci = &get_instance();
        $ci->load->model("vista");

        $fechas = $ci->vista->getfechasproduct($fechaini, $fechafin, $nameproyect);


        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("Reestructura"); //propiedades        
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Productividad");  //título de la hoja 1

        /* $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Identificacion');
          $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Asesor');
          $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Casa Cobranzas');
          $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Provabilidad de Cobro');
          $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Resultado');
          $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Memo');
          $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Fecha Gestion'); */

        $filaFechas = 2;
        $filaResName = 2;
        $filatitle = 2;
        $columtitle = 'B';



        if ($idcasa == 0) {

            $casa = $ci->vista->getcasas();

            foreach ($casa as $cc) {

                $columFechas = 'C';
                $resultName = $ci->vista->getresultadosNameNew($nameproyect);
                $columResName = 'C';

                $resultCod = $ci->vista->getresultadosCodNew($nameproyect);

                $name = $ci->vista->getcasaname2($cc['idCasa']);
                $title = $name;

                $objPHPExcel->getActiveSheet()->setCellValue($columtitle . $filatitle, $title);

                foreach ($resultName as $res) {
                    $filaResName++;
                    foreach ($res as $r) {
                        $objPHPExcel->getActiveSheet()->setCellValue($columResName . $filaResName, $r);
                    }
                }
                $ColumResProduc = 'C';
                foreach ($fechas as $fec) {
                    $columFechas++;
                    $ColumResProduc++;
                    foreach ($fec as $f) {
                        $objPHPExcel->getActiveSheet()->setCellValue($columFechas . $filaFechas, $f);
                        $filaResProduc = $filaFechas;

                        foreach ($resultCod as $result) {
                            $filaResProduc++;
                            foreach ($result as $rrr) {
//echo $f." -- ".$idcasa." -- ".$rrr;
                                $pr = $ci->vista->getProductCod($f, $cc['idCasa'], $rrr, $nameproyect);
//echo " -- ".$pr."</br>";
                                $objPHPExcel->getActiveSheet()->setCellValue($ColumResProduc . $filaResProduc, $pr);
                            }
                        }
                    }
                }
                $columFechas++;

                $filaResName = $filaResName - 4;
                $filaFechas = $filaFechas + 20;
                $filaResName = $filaResName + 10;
                $filatitle = $filatitle + 20;
            }

//echo "Ok";
//die();
            $styleArray = array('font' => array('bold' => true));
            $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
//poniendo una columna con tamaño auto según el contenido
//creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:







            $tablename = "Productividad_" . date("Ymd");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $tablename . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');


            /* header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="' . $tablename);
              header('Cache-Control: max-age=0');
              $objWriter->save('php://output'); */
        } else if ($idcasa > 0) {

            if ($asesor == 0) {
                $asesores = $ci->vista->getasesores($idcasa);


                $countFilas = array();
                
                foreach ($asesores as $ase) {
                    $posicionFila = 0;
                    // echo "1 - ";
                    $columFechas = 'C';
                    $resultName = $ci->vista->getresultadosNameNew($nameproyect);
                    $columResName = 'C';

                    $resultCod = $ci->vista->getresultadosCodNew($nameproyect);

                    $name = $ci->vista->getusername2($ase['idUsuario']);
                    $title = $name;

                    $objPHPExcel->getActiveSheet()->setCellValue($columtitle . $filatitle, $title);

                    foreach ($resultName as $res) {
                        $filaResName++;
                        foreach ($res as $r) {
                            $countFilas[$posicionFila] = 0;
                            $objPHPExcel->getActiveSheet()->setCellValue($columResName . $filaResName, $r);
                            $posicionFila += 1;
                        }
                    }
                    
                    //total por columnas
                    $filaResName++;
                    $objPHPExcel->getActiveSheet()->getStyle($columResName . $filaResName)->getFill()->applyFromArray(array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'startcolor' => array(
                            'rgb' => 'D8D8D8'
                        )
                    ));
                    $objPHPExcel->getActiveSheet()->setCellValue($columResName . $filaResName, "TOTAL");

                    $ColumResProduc = 'C';
                    
                    foreach ($fechas as $fec) {
                        $columFechas++;
                        $ColumResProduc++;
                        $totalColumna = 0;
                        $posicionFila = 0;
                        foreach ($fec as $f) {
                            $objPHPExcel->getActiveSheet()->setCellValue($columFechas . $filaFechas, $f);
                            $filaResProduc = $filaFechas;

                            foreach ($resultCod as $result) {
                                $filaResProduc++;
                                foreach ($result as $rrr) {
                                    
                                    $pr = $ci->vista->getProductUser($f, $ase['idUsuario'], $rrr, $nameproyect);

                                    $objPHPExcel->getActiveSheet()->setCellValue($ColumResProduc . $filaResProduc, $pr);
                                    
                                    $countFilas[$posicionFila] += $pr;
                                    
                                    $totalColumna += $pr;
                                }
                                $posicionFila += 1;
                            }
                        }
                        
                        $filaResProduc++;
                        $objPHPExcel->getActiveSheet()->getStyle($ColumResProduc . $filaResProduc)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => 'D8D8D8'
                            )
                        ));
                        $objPHPExcel->getActiveSheet()->setCellValue($ColumResProduc . $filaResProduc, $totalColumna);
                    }
                    
                    $columFechas++;
                    $objPHPExcel->getActiveSheet()->getStyle($columFechas . $filaFechas)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => 'D8D8D8'
                            )
                        ));
                    $objPHPExcel->getActiveSheet()->setCellValue($columFechas . $filaFechas, "TOTAL");
                    
                    
                    $toti = sizeof($countFilas) -1;
                    $nuevFila = 0;
                    $nuevFila = $filaFechas;
                    $nuevFila += 1;
                    for($i = 0; $i<=$toti; $i++){
                        $objPHPExcel->getActiveSheet()->getStyle($columFechas . $nuevFila)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'startcolor' => array(
                                'rgb' => 'D8D8D8'
                            )
                        ));
                        $objPHPExcel->getActiveSheet()->setCellValue($columFechas . $nuevFila, $countFilas[$i]);
                        $nuevFila++;
                    }


                    $filaResName = $filaResName - 2;
                    $filaFechas = $filaFechas + 33;
                    $filaResName = $filaResName + 6;
                    $filatitle = $filatitle + 33;
                }

//echo "Ok";
//die();
                $styleArray = array('font' => array('bold' => true));
                $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
//poniendo una columna con tamaño auto según el contenido
//creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:


                $tablename = "Productividad_" . date("Ymd");

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="estadistico_' . $tablename . '.xls"');
                header('Cache-Control: max-age=0');
                $objWriter->save('php://output');


                /* header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                  header('Content-Disposition: attachment;filename="' . $tablename);
                  header('Cache-Control: max-age=0');
                  $objWriter->save('php://output'); */
            } else if ($asesor > 0) {


                $asesores = $ci->vista->getasesorsolo($asesor);

                foreach ($asesores as $ase) {

                    $columFechas = 'C';
                    $resultName = $ci->vista->getresultadosNameNew($nameproyect);
                    $columResName = 'C';

                    $resultCod = $ci->vista->getresultadosCodNew($nameproyect);

                    $name = $ci->vista->getusername2($ase['idUser']);
                    $title = $name;

                    $objPHPExcel->getActiveSheet()->setCellValue($columtitle . $filatitle, $title);

                    foreach ($resultName as $res) {
                        $filaResName++;
                        foreach ($res as $r) {
                            $objPHPExcel->getActiveSheet()->setCellValue($columResName . $filaResName, $r);
                        }
                    }
                    $ColumResProduc = 'C';
                    foreach ($fechas as $fec) {
                        $columFechas++;
                        $ColumResProduc++;
                        foreach ($fec as $f) {
                            $objPHPExcel->getActiveSheet()->setCellValue($columFechas . $filaFechas, $f);
                            $filaResProduc = $filaFechas;

                            foreach ($resultCod as $result) {
                                $filaResProduc++;
                                foreach ($result as $rrr) {
//echo $f." -- ".$idcasa." -- ".$rrr;
                                    $pr = $ci->vista->getProductUser($f, $ase['idUser'], $rrr, $nameproyect);
//echo " -- ".$pr."</br>";
                                    $objPHPExcel->getActiveSheet()->setCellValue($ColumResProduc . $filaResProduc, $pr);
                                }
                            }
                        }
                    }
                    $filaResName = $filaResName - 4;
                    $filaFechas = $filaFechas + 20;
                    $filaResName = $filaResName + 10;
                    $filatitle = $filatitle + 20;
                }

//echo "Ok";
//die();
                $styleArray = array('font' => array('bold' => true));
                $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
//poniendo una columna con tamaño auto según el contenido
//creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:


                $tablename = "Productividad_" . date("Ymd");

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="estadistico_' . $tablename . '.xls"');
                header('Cache-Control: max-age=0');
                $objWriter->save('php://output');


                /* header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                  header('Content-Disposition: attachment;filename="' . $tablename);
                  header('Cache-Control: max-age=0');
                  $objWriter->save('php://output'); */
            }
        }
    }

}

?>
<?php

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

        $filaFechas = 3;
        $filaResName = 3;
        $filatitle = 2;
        $columtitle = 'B';

        if ($idcasa == 0) {

            $casa = $ci->vista->getcasas();

            foreach ($casa as $cc) {

                $columFechas = 'C';
                $resultName = $ci->vista->getresultadosName($nameproyect);
                $columResName = 'C';

                $resultCod = $ci->vista->getresultadosCod($nameproyect);

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
                                $pr = $ci->vista->getProductCod($f, $cc['idCasa'], $rrr);
//echo " -- ".$pr."</br>";
                                $objPHPExcel->getActiveSheet()->setCellValue($ColumResProduc . $filaResProduc, $pr);
                            }
                        }
                    }
                }
                $filaResName = $filaResName - 5;
                $filaFechas = $filaFechas + 9;
                $filaResName = $filaResName + 9;
                $filatitle = $filatitle + 9;
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
            header('Content-Disposition: attachment;filename="att_report_' . $tablename . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');


            /* header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="' . $tablename);
              header('Cache-Control: max-age=0');
              $objWriter->save('php://output'); */
        } else if ($idcasa > 0) {


            if ($asesor == 0) {
                $asesores = $ci->vista->getasesores($idcasa);

                foreach ($asesores as $ase) {

                    $columFechas = 'C';
                    $resultName = $ci->vista->getresultadosName($nameproyect);
                    $columResName = 'C';

                    $resultCod = $ci->vista->getresultadosCod($nameproyect);

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
                    $filaResName = $filaResName - 5;
                    $filaFechas = $filaFechas + 9;
                    $filaResName = $filaResName + 9;
                    $filatitle = $filatitle + 9;
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
                header('Content-Disposition: attachment;filename="att_report_' . $tablename . '.xls"');
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
                    $resultName = $ci->vista->getresultadosName($nameproyect);
                    $columResName = 'C';

                    $resultCod = $ci->vista->getresultadosCod($nameproyect);

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
                                    $pr = $ci->vista->getProductUser($f, $ase['idUser'], $rrr,$nameproyect);
//echo " -- ".$pr."</br>";
                                    $objPHPExcel->getActiveSheet()->setCellValue($ColumResProduc . $filaResProduc, $pr);
                                }
                            }
                        }
                    }
                    $filaResName = $filaResName - 5;
                    $filaFechas = $filaFechas + 9;
                    $filaResName = $filaResName + 9;
                    $filatitle = $filatitle + 9;
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
                header('Content-Disposition: attachment;filename="att_report_' . $tablename . '.xls"');
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
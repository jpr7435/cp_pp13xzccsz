<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Notificar todos los errores de PHP
error_reporting(1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class exportdemo {

    function export($tipo, $casa, $nameproyect) {
        
 
        $ci = &get_instance();
        $ci->load->model("vista");



        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("Reestructura S.A.S"); //propiedades
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Demograficos");  //título de la hoja 1



        if ($tipo == 1) {
            $tabla = $ci->vista->getTelefonosCasa($casa, $nameproyect);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Telefono');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Documento');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Ciudad');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Activo');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Agregado');


            /** Loop through the result set 1.0 */
            $rowNumber = 2; //start in cell 1


            foreach ($tabla as $t) {
                $col = 'A'; // start at column A
                $fields = 1;
                foreach ($t as $tab) {
                    if ($fields == 4) {

                        if ($tab == "1") {
                            $completo = "SI";
                        } else {
                            $completo = "NO";
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                    } else if ($fields == 5) {
                        if ($tab == "1") {
                            $completo = "SI";
                        } else {
                            $completo = "NO";
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                    } else {

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                    }

                    $col++;
                    $fields +=1;
                }
                $rowNumber++;
            }

            $styleArray = array('font' => array('bold' => true));
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            
            $tablename = "Telefonos_" . $nameproyect;
            
        }else if( $tipo == 2){
            
            
            $tabla = $ci->vista->getDireccionesCasa($casa, $nameproyect);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Direccion');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Documento');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Ciudad');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Barrio');
            $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Activo');
            $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Agregado');


            /** Loop through the result set 1.0 */
            $rowNumber = 2; //start in cell 1


            foreach ($tabla as $t) {
                $col = 'A'; // start at column A
                $fields = 1;
                foreach ($t as $tab) {
                    if ($fields == 5) {

                        if ($tab == "1") {
                            $completo = "SI";
                        } else {
                            $completo = "NO";
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                    } else if ($fields == 6) {
                        if ($tab == "1") {
                            $completo = "SI";
                        } else {
                            $completo = "NO";
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                    } else {

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                    }

                    $col++;
                    $fields +=1;
                }
                $rowNumber++;
            }

            $styleArray = array('font' => array('bold' => true));
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            
            $tablename = "Direcciones_" . $nameproyect;
            
        }else if( $tipo == 3){
            
            
            $tabla = $ci->vista->getMailsCasa($casa, $nameproyect);
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Mail');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Documento');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Activo');
            $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Agregado');


            /** Loop through the result set 1.0 */
            $rowNumber = 2; //start in cell 1


            foreach ($tabla as $t) {
                $col = 'A'; // start at column A
                $fields = 1;
                foreach ($t as $tab) {
                    if ($fields == 3) {

                        if ($tab == "1") {
                            $completo = "SI";
                        } else {
                            $completo = "NO";
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                    } else if ($fields == 4) {
                        if ($tab == "1") {
                            $completo = "SI";
                        } else {
                            $completo = "NO";
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                    } else {

                        $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                    }

                    $col++;
                    $fields +=1;
                }
                $rowNumber++;
            }
            
           
            $styleArray = array('font' => array('bold' => true));
            $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

            
            $tablename = "Emails_" . $nameproyect;
            
        }
        
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename . ".xls");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

?>
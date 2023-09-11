<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class pausas {

    function export($casa, $ini, $fin, $nameproyect) {

        $ci = &get_instance();
        $ci->load->model("vista");

        $tabla = $ci->vista->getLogPausas($casa, $ini, $fin);
		
		
        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("Cinsist"); //propiedades
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Informe estado de cartera");  //título de la hoja 1

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Usuario');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Pausa');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Duracion');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Fecha');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Casa');

        /** Loop through the result set 1.0 */
        $rowNumber = 2; //start in cell 1


        foreach ($tabla as $t) {
            $col = 'A'; // start at column A
            $fields = 1;
            $cedula = "";
            foreach ($t as $tab) {

                if ($fields == 1) {
                    $res = $ci->vista->getuser($tab);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Sin Asesor";
                    } else {
                        $completo = $res;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 2) {
                    $res = $ci->vista->getPausaid($tab);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Sin Detalle";
                    } else {
                        $completo = $res;
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                }else if ($fields == 5) {
                    $res = $ci->vista->getcasa($tab);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Sin Casa";
                    } else {
                        $completo = $res;
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

        //poniendo una columna con tamaño auto según el contenido
        //creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:
        
        $ini = date("Y-m-d");
        
        $ini2 = explode(" ", $ini);
        $fec = explode("-", $ini2[0]);
        $tablename = "InformePausas"."_" . $fec[0] . $fec[1] . $fec[2];

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename . ".xls");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

?>
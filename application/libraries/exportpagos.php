<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class exportpagos {

    function export($ini, $fin, $casa, $nameproyect) {
        
        $ci = &get_instance();
        $ci->load->model("vista");
        
        $tabla = $ci->vista->getpagosFechas($ini, $fin, $casa, $nameproyect);
        
        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("Reestructura S.A.S"); //propiedades
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Informe de pagos");  //título de la hoja 1

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Fecha Aplicacion');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Fecha Transaccion');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Descripcion');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Documento');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Origen');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Valor Total');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Valor Efectivo');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Valor Cheque');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Obligacion');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Casa');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Asesor');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Compra');


        /** Loop through the result set 1.0 */
        $rowNumber = 2; //start in cell 1


        foreach ($tabla as $t) {
            $col = 'A'; // start at column A
            $fields = 1;
            foreach ($t as $tab) {
                if ($fields == 10) {
                    $res = $ci->vista->getcasa($tab);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Verificar";
                    } else {
                        $completo = $res;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 11) {
                    $res = $ci->vista->getuser($tab);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Verificar";
                    } else {
                        $completo = $res;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 12) {
                    $res = $ci->vista->getCompra($tab, $nameproyect);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Verificar";
                    } else {
                        if(sizeof($res) == 0){
                            $completo = "Verificar";
                        }else{
                            $completo = $res[0]['cartera'];
                        }
                        
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
        $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        //poniendo una columna con tamaño auto según el contenido
        //creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:
        
        
        $tablename = "InformePagos_".$ini."_".$nameproyect;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename . ".xls");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

?>
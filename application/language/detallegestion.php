<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class detallegestion {

    function export($ini, $fin, $casa, $nameproyect) {
        
        $ci = &get_instance();
        $ci->load->model("vista");
        
        $tabla = $ci->vista->getProducFechas($ini, $fin, $casa, $nameproyect);
        
        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("Reestructura S.A.S"); //propiedades
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Informe Detalle de Gestion");  //título de la hoja 1

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Documento');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Fecha Gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Hora');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Telefono');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Accion');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Contacto');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Resultado');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Texto Gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Nombre Tercero');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Asesor');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Tiempo');


        /** Loop through the result set 1.0 */
        $rowNumber = 2; //start in cell 1


        foreach ($tabla as $t) {
            $col = 'A'; // start at column A
            $fields = 1;
            foreach ($t as $tab) {
                if ($fields == 5) {
                    $res = $ci->vista->getAcciones($tab, $nameproyect);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Veirificar";
                    } else {
                        $completo = $res[0]['descripcion'];
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 6) {
                    $res = $ci->vista->getContacto($tab, $nameproyect);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Veirificar";
                    } else {
                        if($res){
                            $completo = $res[0]['descripcion'];
                        }else{
                            $completo = "Veirificar";
                        }
                        
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                }else if ($fields == 7) {
                    $res = $ci->vista->getResultado($tab, $nameproyect);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Verificar";
                    } else {
                        if($res){
                            $completo = $res[0]['descripcion'];
                        }else{
                            $completo = "Veirificar";
                        }
                        
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                }else if ($fields == 10) {
                    $res = $ci->vista->getuser($tab);
                    if ($tab == 0 || $tab == '') {
                        $completo = "Verificar";
                    } else {
                        $completo = $res;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                }  else {

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                }

                $col++;
                $fields +=1;
            }
            $rowNumber++;
        }

        $styleArray = array('font' => array('bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

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
        //poniendo una columna con tamaño auto según el contenido
        //creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:
        
        $ini2 = explode(" ", $ini);
        $fec = explode("-", $ini2[0]);
        $tablename = "DetalleGestion_".$nameproyect."_".$fec[0].$fec[1].$fec[2];

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename . ".xls");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

?>
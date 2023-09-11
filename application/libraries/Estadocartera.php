<?php

ini_set('memory_limit', '512M');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class Estadocartera {

    function export($nameproyect) {

        $ci = &get_instance();
        $ci->load->model("Vista");

        $tabla = $ci->Vista->getTotalClientes($nameproyect);


        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("Puntualmente S.A.S"); //propiedades
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Informe estado de clientes");  //título de la hoja 1

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Documento');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nombre');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Saldo Pareto');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Asesor');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Mejor gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Ultima gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Fecha ultima gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Total Gestiones');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Codigo Mejor Gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Fecha');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Valor');

        /** Loop through the result set 1.0 */
        $rowNumber = 1; //start in cell 1

        foreach ($tabla as $t) {
            $col = 'A'; // start at column A
            $fields = 1;
            foreach ($t as $tab) {
                $mejor = "";

                if ($fields == 4) {
                    $res = $ci->Vista->getusuario($tab);

                    if ($tab == 0 || $tab == '') {
                        $completo = "Sin Asesor";
                    } else {
                        $completo = $res;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 5) {
                    $res = $ci->Vista->getResultado($tab, $nameproyect);

                    if ($tab == 0 || $tab == '') {
                        $completo = "Sin Gestion";
                    } else {
                        if (isset($res[0]['descripcion'])) {
                            $completo = $res[0]['descripcion'];
                        } else {
                            $completo = "Sin Gestion";
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 6) {
                    $res = $ci->Vista->getResultado($tab, $nameproyect);

                    if ($tab == 0 || $tab == '') {
                        $completo = "Sin Gestion";
                    } else {
                        if (isset($res[0]['descripcion'])) {
                            $completo = $res[0]['descripcion'];
                        } else {
                            $completo = "Sin Gestion";
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 7) {
                    $res = $ci->Vista->getTotalCalls($tab, $nameproyect);

                    $completo = $res[0]['total'];

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                }

                $col++;
                $fields += 1;
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

        $ini = date("Ymd");

        $tablename = "EstadoCartera_" . $nameproyect . "_" . $ini;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename . ".xls");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

?>
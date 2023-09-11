<?php
ini_set('max_execution_time', 300);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/** PHPExcel */
require_once 'excel/PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'excel/PHPExcel/IOFactory.php';

class gestion {

    function export() {

        $ci = &get_instance();
        $ci->load->model("vista");

        $tabla = $ci->vista->getGestionInfo();

        $objPHPExcel = new PHPExcel();                      //creando un objeto excel
        $objPHPExcel->getProperties()->setCreator("SICCOL"); //propiedades
        $objPHPExcel->setActiveSheetIndex(0);               //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Informe Gestion");  //título de la hoja 1

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Obligacion');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Documento');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Saldo Inicial');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Saldo Actual');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Dias en Mora Inicial');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Dias en Mora Actual');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Nombre');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Asesor');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Ultima Fecha Gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Mejor Gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Ultima Gestion');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Fecha Promesa');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Valor Promesa');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Obligacion Promesa');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Fecha Actualizacion');

        /** Loop through the result set 1.0 */
        $rowNumber = 2; //start in cell 1


        foreach ($tabla as $t) {
            $col = 'A'; // start at column A
            $fields = 1;
            foreach ($t as $tab) {



                if ($fields == 1) {
                    $tab = "'" . $tab;
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else if ($fields == 2) {
                    $clie = $ci->vista->gestClieTotal($tab);
                    $hist = $ci->vista->gestHist($tab);
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else if ($fields == 7) {

                    $tab = $clie[0]['nombre'];

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else if ($fields == 8) {
                    if(sizeof($clie)>0){
                       $res = $ci->vista->getuserDatos($clie[0]['idAsesor']);
                        if($clie[0]['idAsesor'] == 0){
                            $completo = "";
                        }else{
                            $completo = $res[0]['nombre'];
                        }
                    }else{
                        $completo = "Sin Asesor";
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $completo);
                } else if ($fields == 9) {
                    $tab = $clie[0]['ultimaGestion'];

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else if ($fields == 10) {
                    $result = $ci->vista->getresult($clie[0]['idResultado']);

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $result);
                } else if ($fields == 11) {

                    if ($tab == 0 || $tab == '') {
                        $result = "Sin Resultado";
                    }
                    if (sizeof($hist) == 0) {
                        $result = "Sin Resultado";
                    } else {
                        $result = $ci->vista->getresult($hist[0]['idResultado']);
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $result);
                } else if ($fields == 12) {
                    if (sizeof($hist) == 0) {
                        $tab = "0000-00-00";
                    } else {
                        $tab = $hist[0]['fechaAcuerdo'];
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else if ($fields == 13) {
                    if (sizeof($hist) == 0) {
                        $tab = 0;
                    } else {
                        $tab = $hist[0]['vlAcuerdo'];
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else if ($fields == 14) {
                    if (sizeof($hist) == 0) {
                        $tab = "";
                    } else {
                        $tab = "'" . $hist[0]['ohAcuerdo'];
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                } else {

                    $objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $tab);
                }

                $col++;
                $fields +=1;
            }
            $rowNumber++;
        }

        $styleArray = array('font' => array('bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray);                  //poniendo en negritas una fila

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
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        //poniendo una columna con tamaño auto según el contenido
        //creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:

        $fec = date("Ymd");
        $tablename = "Gestion_" . $fec;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename . ".xls");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}

?>
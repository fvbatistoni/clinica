<?php
include './header.php';
include './ee-config.php';

// Database configuration
$dbHost     = DB_HOST;
$dbUsername = DB_USER;
$dbPassword = DB_PASSWORD;
$dbName     = DB_NAME;

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
    $data  = addslashes(strtolower($_POST['data']));                                      
    // Checa se já existe agenda com esta data no banco
    $prevQuery = "SELECT data FROM agendas WHERE data = '".$data."'";
    $prevResult = $db->query($prevQuery);

    if($prevResult->num_rows > 0){
        $qstring = '?status=error';
        
        header("Location: agendaIndex.php".$qstring);
    } else {
        // Validate whether selected file is a CSV file
        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
            
            // If the file is uploaded
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                
                // Open uploaded CSV file with read-only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                
                // Skip the first line
                fgetcsv($csvFile);                                                  
                                                      
                // Parse data from CSV file line by line
                while(($line = fgetcsv($csvFile)) !== FALSE){
                    // Get row data                
                    $local_atendimento   = !empty($line[0])?$line[0]:'';
                    $data  = !empty($line[1])?$line[1]:'';
                    if($line[2] != ''){
                      $nome_paciente = $line[2];
                    } else {
                      $nome_paciente = null;
                    }
                    if($line[3] != ''){
                      $id_paciente = $line[3];
                    } else {
                      $id_paciente = null;
                    }
                    if($line[4] == ''){
                      $tipo = null;
                    } else {
                      $tipo = $line[4];                      
                    }
                    if($line[5] != ''){
                      $id_convenio = $line[5];
                    } else {
                      $id_convenio = null;
                    }
                    $hora_consulta = !empty($line[6])?$line[6]:'';
                    if($line[7] != ''){
                      $hora_atendimento = $line[7];
                    } else {
                      $hora_atendimento = null;
                    }
                    if($line[8] != '0'){
                      $pontualidade = null;
                    } else {
                      $pontualidade = '0';
                    }
                    if($line[9] != '0'){
                      $valor_pago = null;
                    } else {
                      $valor_pago = '0';
                    }                                        
                    $desconto = !empty($line[10])?$line[10]:'';
                    $data_pagamento = !empty($line[11])?$line[11]:'';
                    $created = !empty($line[12])?$line[12]:'';
                    $modified = !empty($line[13])?$line[13]:'';
                    $status = !empty($line[14])?$line[14]:'';

                    $db->query("INSERT INTO agendas (local_atendimento, data, nome_paciente, id_paciente, tipo, id_convenio, hora_consulta, hora_atendimento, pontualidade, valor_pago, desconto, data_pagamento, created, modified, status) VALUES ('".$local_atendimento."','".$data."',".($nome_paciente==NULL?"NULL":"'$nome_paciente'").",".($id_paciente==NULL?"NULL":"'$id_paciente'").",".($tipo==NULL?"NULL":"'$tipo'").",".($id_convenio==NULL?"NULL":"'$id_convenio'").",'".$hora_consulta."',".($hora_atendimento ==NULL?"NULL":"'$hora_atendimento '").",".($pontualidade==NULL?"NULL":"'$pontualidade'").",".($valor_pago==NULL?"NULL":"'$valor_pago'").",'".$desconto."','".$data_pagamento."','".$created."','".$modified."','".$status."')");
                                       
                    }                

                // Close opened CSV file
                fclose($csvFile);
                
                $qstring = '?status=success';
            }else{
                $qstring = '?status=error';
            }
        }
    }
}

// Redirect to the listing page
header("Location: agendaIndex.php".$qstring);
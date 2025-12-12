<?php
//setting header to json
header('Content-Type: application/json');

if(is_file('../ee-config.php')==true){
    include '../ee-config.php';
} else {
    include '../../ee-config.php';
} //database

//get connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
$query = sprintf("SELECT
                            COUNT(CASE WHEN MONTH(data)= 1 THEN id END)AS jan,
                            COUNT(CASE WHEN MONTH(data)= 2 THEN id END)AS fev,
                            COUNT(CASE WHEN MONTH(data)= 3 THEN id END)AS mar,
                            COUNT(CASE WHEN MONTH(data)= 4 THEN id END)AS abr,
                            COUNT(CASE WHEN MONTH(data)= 5 THEN id END)AS mai,
                            COUNT(CASE WHEN MONTH(data)= 6 THEN id END)AS jun,
                            COUNT(CASE WHEN MONTH(data)= 7 THEN id END)AS jul,
                            COUNT(CASE WHEN MONTH(data)= 8 THEN id END)AS ago,
                            COUNT(CASE WHEN MONTH(data)= 9 THEN id END)AS 'set',
                            COUNT(CASE WHEN MONTH(data)= 10 THEN id END)AS 'out',
                            COUNT(CASE WHEN MONTH(data)= 11 THEN id END)AS nov,
                            COUNT(CASE WHEN MONTH(data)= 12 THEN id END)AS dez
                            FROM agendas
                            WHERE YEAR(data)=2019 AND nome_paciente is not null AND hora_consulta is not null AND hora_atendimento is null");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);
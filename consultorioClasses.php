<?php

include '../ee-config.php';

class Contato {

    private $dbHost     = DB_HOST;

    private $dbUsername = DB_USER;

    private $dbPassword = DB_PASSWORD;

    private $dbName     = DB_NAME;

    private $pdo;



    public function __construct() {

        $this->pdo = new PDO( "mysql:dbname=".DB_NAME.";host=".DB_HOST."", "".DB_USER."", "".DB_PASSWORD."" );

    }



    private function existePaciente( $nome ) {

        $sql = "SELECT * FROM info_pacientes WHERE nome = :nome";

        $sql = $this->pdo->prepare( $sql );

        $sql->bindValue( ':nome', $nome );

        $sql->execute();



        if ( $sql->rowCount() > 0 ) {

            return true;

        } else {

            return false;

        }

    }



    private function getConvenioId( $convenio ) {

        // Elimina dificuldade para encontrar o ID do Convenio

        $conv = array(
            "Unimed Intercambio" => "Unimed", 
            "Unimed Correios" => "Unimed", 
            "Postal Saude" => "Unimed",
            "Sulamerica" => "Sul Am&eacute;rica",
            "Sul America" => "Sul Am&eacute;rica", 
            "Medservice" => "Mediservice",          
            "Saude Bradesco" => "Bradesco",
            "Bradesco Sa&uacute;de" => "Bradesco",
            "CESP" => "Funda&ccedil;&atilde;o CESP",
            "Beneficencia" => "Sa&uacute;de Benefic&ecirc;ncia",
            "Golden" => "Golden Cross",
            "Gama" => "Gama Sa&uacute;de",
            "Notredame" => "Notre Dame",
            "Medisanita" => "Medisanitas"
          );



        $conv_keys = array_keys( $conv );

        $conv_values = array_values( $conv );



        // Procura e armazena o id do convênio

        $sql = "SELECT id FROM convenios WHERE nome = :convenio";

        $sql = $this->pdo->prepare( $sql );

        $sql->bindValue( ":convenio", str_replace( $conv_keys, $conv_values, $convenio ) );

        $sql->execute();



        $array = array();

        if ( $sql->rowCount() > 0 ) {

            $array = $sql->fetch();

            $id_convenio = $array[ 'id' ];

            return $array[ 'id' ];

        }

        return '';

    }



    public function getAll() {

        $sql = "SELECT * FROM agendas ORDER BY id DESC LIMIT 10";

        $sql = $this->pdo->query( $sql );



        if ( $sql->rowCount() > 0 ) {

            return $sql->fetchAll();

        } else {

            return array();

        }

    }



    public function adicionar( $nome, $sexo, $nascimento, $id_convenio, $telefone ) {

        if ( $this->existePaciente( $nome ) == false ) {

            $sql = "INSERT INTO info_pacientes (sexo, nome, nascimento, id_convenio, telefone) VALUES (:sexo, :nome, :nascimento, :id_convenio, :telefone)";

            $sql = $this->pdo->prepare( $sql );

            $sql->bindValue( ':sexo', $sexo );

            $sql->bindValue( ':nome', strtoupper( $nome ) );

            $sql->bindValue( ':nascimento', $nascimento );

            $sql->bindValue( ':id_convenio', $id_convenio );

            $sql->bindValue( ':telefone', $telefone );

            $sql->execute();



        } else {

            $sql = "UPDATE info_pacientes SET sexo = :sexo, nome = :nome, nascimento = :nascimento, id_convenio = :id_convenio, telefone = :telefone WHERE nome = :nome";

            $sql = $this->pdo->prepare( $sql );

            $sql->bindValue( ':sexo', $sexo );

            $sql->bindValue( ':nome', strtoupper( $nome ) );

            $sql->bindValue( ':nascimento', $nascimento );

            $sql->bindValue( ':id_convenio', $id_convenio );

            $sql->bindValue( ':telefone', $telefone );

            $sql->execute();

        }

    }





    public function getPacienteId( $nome ) {

        $sql = "SELECT id FROM info_pacientes WHERE nome = :nome";

        $sql = $this->pdo->prepare( $sql );

        $sql->bindValue( ":nome", $nome );

        $sql->execute();



        $array = array();

        if ( $sql->rowCount() > 0 ) {

            $array = $sql->fetch();

            $id_convenio = $array[ 'id' ];

            return $array[ 'id' ];

        }

        return $nome;

    }





    private function inverteData( $data ) {

        $parteData = explode( "/", $data );

        $dataInvertida = $parteData[ 2 ] . "-" . $parteData[ 1 ] . "-" . $parteData[ 0 ];

        return $dataInvertida;

    }







    public function existeAgenda( $data ) {

        $sql = "SELECT * FROM agendas WHERE data = :data";

        $sql = $this->pdo->prepare( $sql );

        $sql->bindValue( ':data', $data );

        $sql->execute();



        if ( $sql->rowCount() > 0 ) {

            return true;

        } else {

            return false;

        }

    }







    /* Inserir a tabela da agenda diária do Doctors no novo sistema, convertendo data, hora e nome;

     * $contato = new Contato();

     * $contato->dumpAgenda ($nome_paciente,$telefone,$convenio,$data,$hora_consulta,$hora_atendimento);  */



    public function dumpAgenda( $table, $data ) {

        // O $x começa em 1 para pular os cabeçalhos das tabelas

        // $table[$x][0] = hora_consulta

        // $table[$x][1] = nome_paciente

        // $table[$x][3] = id_convenio

        // $table[$x][4] = tipo

        // $table[$x][9] = hora_atendimento



        for ( $x = 1; $x < count( $table ); $x++ ) {



                   // SE o nome_paciente estiver cheio & hora_atendimento estiver vazia = PACIENTE FALTOU

                if(trim($table[$x][9])=='-'){

                    $nomes = explode("\n", $table[$x][1]);

                    $nome = strtoupper(trim($nomes[1]));



                    if($nome=='-'){

                        $nome_final=null;

                    } else {

                        $nome_final=$nome;

                    }

                    

                    $retornos = array('Retorno','1ª/Retorno','Cons/Retorno','Retorno/Retorno','Puericultura/Retorno');

                    if (in_array(trim($table[$x][4]),$retornos)){

                        $tipo = 1;

                    } else {

                        $tipo = 0;

                    }



                    $convenio = trim( $table[ $x ][ 3 ] );

                    $hora_consulta = trim( $table[ $x ][ 0 ] ) . ':00';

                    $sql = "INSERT INTO `agendas` SET 

                                        `data` = :data,

                                        `local_atendimento` = 3, 

                                        `tipo` = :tipo,

                                        `id_convenio` = :id_convenio, 

                                        `nome_paciente` = :nome,

                                        `id_paciente` = :id_paciente, 

                                        `hora_consulta` = :hora_consulta,

                                        `hora_atendimento` = null,

                                        `pontualidade` = null";

                    $sql = $this->pdo->prepare( $sql );

                    $sql->bindValue( ":data", $data );

                    $sql->bindValue( ":nome", $nome_final );

                    $sql->bindValue( ":id_convenio", $this->getConvenioId( $convenio ) );

                    $sql->bindValue( ":id_paciente", $this->getPacienteId( $nome ) );

                    $sql->bindValue( ":tipo", $tipo );

                    $sql->bindValue( ":hora_consulta", $hora_consulta );                    

                    $sql->execute();

                } 

                else { // SE o nome_paciente estiver cheio & hora_atendimento cheio = PACIENTE ATENDIDO

                    $nomes = explode("\n", $table[$x][1]);

                    $nome = strtoupper(trim($nomes[1]));                    

                    $hora_consulta = trim( $table[ $x ][ 0 ] ) . ':00';

                    $hora_atendimento = trim( $table[ $x ][ 9 ] ) . ':00';

                    $retornos = array('Retorno','1ª/Retorno','Cons/Retorno','Retorno/Retorno','Puericultura/Retorno');

                    if (in_array(trim($table[$x][4]),$retornos)){

                        $tipo = 1;

                    } else {

                        $tipo = 0;

                    }

                    $convenio = trim( $table[ $x ][ 3 ] );

                    $sql = "INSERT INTO `agendas` SET 

                                        `data` = :data,

                                        `local_atendimento` = 3, 

                                        `nome_paciente` = :nome,

                                        `id_paciente` = :id_paciente, 

                                        `tipo` = :tipo,

                                        `id_convenio` = :id_convenio, 

                                        `hora_consulta` = :hora_consulta, 

                                        `hora_atendimento` = :hora_atendimento,

                                        `pontualidade` = :pontualidade";

                    $sql = $this->pdo->prepare( $sql );

                    $sql->bindValue( ":data", $data );

                    $sql->bindValue( ":nome", $nome );

                    $sql->bindValue( ":id_paciente", $this->getPacienteId( $nome ) );

                    $sql->bindValue( ":hora_consulta", $hora_consulta );

                    $sql->bindValue( ":hora_atendimento", $hora_atendimento );

                    $sql->bindValue( ":id_convenio", $this->getConvenioId( $convenio ) );

                    $sql->bindValue( ":tipo", $tipo );

                    $sql->bindValue( ":pontualidade", $this->atendimentoNoHorario( $hora_consulta, $hora_atendimento ) );

                    $sql->execute();

                }  



            }          



        

    }



    private function atendimentoNoHorario( $hora_consulta, $hora_atendimento ) {

        if ( $hora_atendimento == '-'

            OR $hora_atendimento == 'Chegou' ) {

            return $pontualidade = 'null';

        } else {

            $h1 = explode( ':', $hora_consulta );

            $h2 = explode( ':', $hora_atendimento );

            return $pontualidade = ( ( $h2[ 0 ] * 3600 ) + ( $h2[ 1 ] * 60 ) ) - ( ( $h1[ 0 ] * 3600 ) + ( $h1[ 1 ] * 60 ) );

        }

    }

}
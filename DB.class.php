<?php
declare(strict_types=1);
/*
 * DB Class
 * This class is used for database related (connect, insert, update, and delete) operations
 * @author    CodexWorld.com
 * @url        http://www.codexworld.com
 * @license    http://www.codexworld.com/license
 */
require_once __DIR__ . '/ee-config.php';

class DB {    
    private $dbHost     = DB_HOST;
    private $dbUsername = DB_USER;
    private $dbPassword = DB_PASSWORD;
    private $dbName     = DB_NAME;
    private $db;

    public function __construct(){
        if(!isset($this->db)){
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            } else {
                // Define o charset da conexão como utf8mb4
                if (!$conn->set_charset("utf8mb4")) {
                    die("Error loading character set utf8mb4: " . $conn->error);
                }
                
                // Atribui a conexão ao atributo da classe
                $this->db = $conn;
            }
        }
    }

    public function getLink() {
        return $this->db;
    }

    public function getLastError() {
        return $this->db->error;
    }

    public function insert($table, $data) {
        $data['created'] = date('Y-m-d H:i:s');
        $data['modified'] = date('Y-m-d H:i:s');

        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_map([$this->db, 'real_escape_string'], array_values($data))) . "'";

        $sql = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";

        echo "<pre>SQL Gerado:\n" . $sql . "</pre>";

        $result = $this->db->query($sql);

        if ($result) {
            echo "<pre>Inserção OK. ID gerado: " . $this->db->insert_id . "</pre>";
            return $this->db->insert_id;
        } else {
            echo "<pre>Erro ao inserir: " . $this->db->error . "</pre>";
            return false;
        }
    }

    public function update($table, $data, $conditions) {
        $data['modified'] = date('Y-m-d H:i:s');

        $set = '';
        $i = 0;
        foreach($data as $key => $value) {
            $pre = ($i > 0)?', ':'';
            $set .= $pre.$key." = '".$this->db->real_escape_string($value)."'";
            $i++;
        }

        $where = '';
        if(!empty($conditions)) {
            $where = ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value) {
                $pre = ($i > 0)?' AND ':'';
                $where .= $pre.$key." = '".$this->db->real_escape_string($value)."'";
                $i++;
            }
        }

        $sql = "UPDATE ".$table." SET ".$set.$where;

        echo "<pre>SQL Update:\n" . $sql . "</pre>";

        $result = $this->db->query($sql);

        if ($result) {
            echo "<pre>Atualização OK.</pre>";
            return true;
        } else {
            echo "<pre>Erro ao atualizar: " . $this->db->error . "</pre>";
            return false;
        }
    }

    public function getRows($table, $conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select", $conditions) ? $conditions['select'] : '*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where", $conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("like", $conditions) && !empty($conditions['like'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $likeSQL = '';
            foreach($conditions['like'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $likeSQL .= $pre.$key." LIKE '%".$value."%'";
                $i++;
            }
            $sql .= '('.$likeSQL.')';
        }

        if(array_key_exists("like_or", $conditions) && !empty($conditions['like_or'])){
            $sql .= (strpos($sql, 'WHERE') !== false)?' AND ':' WHERE ';
            $i = 0;
            $likeSQL = '';
            foreach($conditions['like_or'] as $key => $value){
                $pre = ($i > 0)?' OR ':'';
                $likeSQL .= $pre.$key." LIKE '%".$value."%'";
                $i++;
            }
            $sql .= '('.$likeSQL.')';
        }

        if(array_key_exists("order_by", $conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        } elseif(!array_key_exists("start", $conditions) && array_key_exists("limit", $conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }

        $result = $this->db->query($sql);

        $data = [];

        if(array_key_exists("return_type", $conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                default:
                    $data = '';
            }
        } else {
            if($result && $result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
            }
        }
        return !empty($data) ? $data : false;
    }

    public function delete($table, $conditions) {
        $where = '';
        if(!empty($conditions)) {
            $where = ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value) {
                $pre = ($i > 0)?' AND ':'';
                $where .= $pre.$key." = '".$this->db->real_escape_string($value)."'";
                $i++;
            }
        }

        $sql = "DELETE FROM ".$table.$where;

        $result = $this->db->query($sql);

        if ($result) {
            return true;
        } else {
            echo "<pre>Erro ao deletar: " . $this->db->error . "</pre>";
            return false;
        }
    }

    public function calcula_idade_anos($nascimento, $interese){
        date_default_timezone_set('America/Sao_Paulo');
        $data1 = new DateTime($nascimento);     
        $interese = new DateTime();
        $intervalo = $data1->diff($interese);
        return $intervalo->format('%y');    
    }

    public function getfinanceiroCat($categoriaId) {
        $sql = "SELECT * FROM financeiro_cats WHERE id = '".$this->db->real_escape_string($categoriaId)."' LIMIT 1";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function getAllFinanceiroCats() {
        $sql = "SELECT * FROM financeiro_cats WHERE status = 1 ORDER BY nome ASC";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function getAniversariantes($hoje) {
        $data = array();
        $hoje = $this->db->real_escape_string($hoje);
        $sql = "SELECT name, phone1, phone2, aniversario 
                FROM aniversariantes 
                WHERE DATE_FORMAT(aniversario, '%m-%d') = '$hoje'";

        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
    public function getConvenioData($id){
    $sql = "SELECT * FROM convenios WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
    }
    
    public function getConvenios(){
		try {
		    $dbconn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', DB_USER, DB_PASSWORD);
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	    $stmt = $dbconn->prepare("SELECT id,nome FROM convenios ORDER BY nome");
	    $stmt->execute();
	    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    return $data;
	}
}

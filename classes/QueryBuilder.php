<?php

namespace classes;

use mysqli;

class QueryBuilder
{
    public $table;
    public $query;
    protected $host 	= 'localhost';
    protected $username = 'fortechm_web';
    protected $password = 'Ipr}~*NrLKT?';
    protected $database = 'fortechm_mywallet';
    protected $connection;

    public function table($tbl)
    {
        $this->table = $tbl;
    }  

    public function where($where)
    {
        $query = "SELECT * FROM ". $this->table;
        $query .= ' WHERE ';
        foreach ($where as $key => $value) {
            $item_where[] = $key  ." = '". $value ."'";
        }
        $query .= implode (' AND ',$item_where);
        
        $this->query = $query;
        return $this->query;
    }

    public function order($column)
    {
        $this->query = $this->query ." ORDER BY ". $column;
        return $this->query;
    }

    public function insert($data)
    {
        $query = "INSERT INTO ". $this->table;
        $query .= " (". implode(', ', array_keys($data)) . ") VALUES (";
        foreach($data as $values){
            $value[] = "'". $values ."'";
        }
        $query .= implode (',',$value) .")";
        
        $this->query = $query;
        $result = $this->execute();
        
        return array(
            "Success" => $result,
            "Query"   => $query
        );
    }

    public function update($data, $where)
    {
        $query = 'UPDATE '. $this->table .' SET ';
        $item = array();
        foreach ($data as $key => $value) {
            $item_update[] = $key  ." = '". $value ."'";
        }
        $query .= implode (', ',$item_update);
        $query .= ' WHERE ';
        foreach ($where as $key => $value) {
            $item_where[] = $key  ." = '". $value ."'";
        }
        $query .= implode (', ',$item_where);
        
        $this->query = $query;
        $result = $this->execute();

        return array(
            "Success" => $result,
            "Query"   => $query
        );        
    }

    public function delete($where)
    {
        $query = "DELETE FROM ". $this->table;
        $query .= ' WHERE ';
        foreach ($where as $key => $value) {
            $item_where[] = $key  ." = '". $value ."'";
        }
        $query .= implode (' AND ',$item_where);

        $this->query = $query;
        $result = $this->execute();

        return array(
            "Success" => $result,
            "Query"   => $query
        );        
    }

    public function find($id)
    {
        $query = "SELECT * FROM ". $this->table . " WHERE id = ". $id;

        $this->connection = new mysqli(
            $this->host, $this->username, $this->password, $this->database
        );

        if (!$this->connection){
            echo "Error while triying connect!";
        }

        $this->query = $query;
        $data = array();
        if ($result = $this->connection->query($this->query)) {
            while ($object = $result->fetch_object()) {
                $data[] =  $object;
            }
            $result->close();
        }
        return $data;
    }

    public function first($sqlString = null)
    {
        $this->connection = new mysqli(
            $this->host, $this->username, $this->password, $this->database
        );

        if (!$this->connection){
            echo "Error while triying connect!";
        }

        if ($sqlString){
            $this->query = $sqlString;
        }

        $object = array();
        if ($result = $this->connection->query($this->query)) {
            $object = $result->fetch_object();
            $result->close();
        }
        
        return $object;
    }

    public function get($sqlString = null)
    {
        $this->connection = new mysqli(
            $this->host, $this->username, $this->password, $this->database
        );

        if (!$this->connection){
            echo "Error while triying connect!";
        }

        if ($sqlString){
            $this->query = $sqlString;
        }

        $data = array();
        if ($result = $this->connection->query($this->query)) {
            while ($object = $result->fetch_object()) {
                $data[] =  $object;
            }
            $result->close();
        }
        return $data;
    }

    public function all()
    {
        $this->connection = new mysqli(
            $this->host, $this->username, $this->password, $this->database
        );

        if (!$this->connection){
            echo "Error while triying connect!";
        }

        $data = array();
        $this->query = "SELECT * FROM ". $this->table;
        if ($result = $this->connection->query($this->query)) {
            while ($object = $result->fetch_object()) {
                $data[] =  $object;
            }
            $result->close();
        }
        return $data;
    }    

    protected function execute()
    {
        $this->connection = new mysqli(
            $this->host, $this->username, $this->password, $this->database
        );

        if (!$this->connection){
            echo "Error while triying connect!";
        }

        try {
            if ($this->connection->query($this->query)) {
                return true;
            }
        
        } catch(Exception $e){
            throw new Exeption("Error: ". $e->getMessage());
        }
        
        return false;
    }

}

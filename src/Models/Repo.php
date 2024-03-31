<?php 

require_once "..\..\Database\dbConnection.php";
abstract class Repo {
    protected $db;
    public function __construct(protected $tableName) {
        $this->db = dbConnection::getconnection();
    }

    public function findAll() {
        $req = "SELECT * FROM {$this->tableName}";
        $response = $this->db->query($req);
        return  $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById($id) {
        $req = "SELECT * FROM {$this->tableName} where id = ?";
        $response = $this->db->prepare($req);
        return $response->execute([$id]);
    }

    public function insert(array $data) {
        $keys = array_keys($data);
        $keysString = implode(', ', $keys);
        $params = array_fill(0, count($keys),'?');
        $paramsString = implode(', ', $params);

        $request = "INSERT INTO `{$this->tableName}` ($keysString) VALUES ($paramsString)";
        $response = $this->db->prepare($request);

        return $response->execute(array_values($data));
    }

}
<?php 
require_once "Database\dbConnection.php";
abstract class Repo {
    protected $db;
    public function __construct(protected $tableName) {
        $this->db = dbConnection::getconnection();
    }

    public function findAll() {
        $req = "SELECT * FROM {$this->tableName}";
        $response = $this->db->query($req);
        $response->execute();
        return  $response->fetchAll(PDO::FETCH_OBJ);
    }

    public function findById($id) {
        $req = "SELECT * FROM {$this->tableName} where id = ?";
        $response = $this->db->prepare($req);
        $response->execute([$id]);
        return $response->fetch(PDO::FETCH_OBJ);
    }

    public function edit(array $data, $eventId) {
        $sets = [];
        foreach ($data as $key => $value) {
            $sets[] = "{$key} = ?";
        }
        $setsString = implode(', ', $sets);

        $request = "UPDATE `{$this->tableName}` SET {$setsString} WHERE id = ?";
        $response = $this->db->prepare($request);

        $values = array_values($data);
        $values[] = $eventId;

        return $response->execute($values);
    }
}
<?php
require_once("../../config.php");

class BlobDemo {

    private $conn = null;

    /**
     * Open the database connection
     */
    public function __construct() {
        global $hostname;
        global $username;
        global $password;
        global $name;
        // open database connection
        $connectionString = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $hostname, $name);

        try {
            $this->conn = new PDO($connectionString, $username, $password);
            //for prior PHP 5.3.6
            //$conn->exec("set names utf8");
        } catch (PDOException $pe) {
            echo $pe->getMessage();
            die($pe->getMessage());
        }
    }

    /**
     * close the database connection
     */
    public function __destruct() {
        // close the database connection
        $this->conn = null;
    }

    /**
     * select data from the the files
     * @param int $id
     * @return array contains mime type and BLOB data
     */
    function selectBlob($id) {

        $sql = "SELECT mime, content_file as data FROM files WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array(":id" => $id));
        $stmt->bindColumn(1, $mime);
        $stmt->bindColumn(2, $data, PDO::PARAM_LOB);

        $stmt->fetch(PDO::FETCH_BOUND);

        return array("mime" => $mime,
            "data" => $data);
    }

}

$bob = new BlobDemo();
$a = $bob->selectBlob((int) filter_input(INPUT_GET, "id"));

header("Content-Type:" . $a['mime']);
echo $a['data'];
print_r(error_get_last());
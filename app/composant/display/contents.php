<?php

/**
 * select data from the the files
 * @param int $id
 * @return array contains mime type and BLOB data
 */
function selectBlob($id) {
 
 $sql = "SELECT mime,
 content_file as data
 FROM files
 WHERE id = :id";
 
 $stmt = $this->conn->prepare($sql);
 $stmt->execute(array(":id" => $id));
 $stmt->bindColumn(1, $mime);
 $stmt->bindColumn(2, $data, PDO::PARAM_LOB);
 
 $stmt->fetch(PDO::FETCH_BOUND);
 
 return array("mime" => $mime,
      "data" => $data);
 
}

$a = selectBlob(filter_input(INPUT_GET, "id"));

header("Content-Type:" . $a['mime']);
echo $a['data'];

<?php
echo header('Access-Control-Allow-Origin: *');
echo header('Content-type: application/json');

try {
  $db =  new PDO('mysql:host=localhost;dbname=shoppinglist;charset=utf8', 
                'root', '');
  $sql = "select * from item";
  $query = $db->query($sql);
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  echo header('HTTP/1.1 200 OK');
  echo json_encode($results);
} catch(PDOException $pdoex) {
  echo header('HTTP/1.1 500 Internal Server Error');
  $error = array('error' => $pdoex->getMessage());
  echo json_encode($error);
  exit;
}

?>
<?php
echo header('Access-Control-Allow-Origin: http://localhost:3000');
echo header('Access-Control-Allow-Credentials: true');
echo header('Access-Control-Allow-Methods: POST, OPTIONS')
echo header('Access-Control-Allow-Headers: Accept, Content-Type, Access-Control-Allow-Header');
echo header('Content-type: application/json');

$input = json_encode(file_get_contents('php://input'));
$description = filter_var($input->desc,FILTER_SANITIZE_STRING);
$amount = filter_var($input->amount,FILTER_SANITIZE_NUMBER_INT);

try {
  $db =  new PDO('mysql:host=localhost;dbname=shoppinglist;charset=utf8', 
                'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $query = $database->prepare("INSERT INTO item(description, amount)".
    "VALUES(:desc, :num)");
  $query->bindValue(":desc", $description, PDO::PARAM_STR);
  $query->bindValue(":num", $amount, PDO::PARAM_INT);
  $query->execute();

  echo header('HTTP/1.1 200 OK');
  $data = array('id' => $db->lastInsertId(), 'description' => $description, 'amount' => $amount);
  echo json_encode($data);
} catch(PDOException $pdoex) {
  echo header('HTTP/1.1 500 Internal Server Error');
  $error = array('error' => $pdoex->getMessage());
  echo json_encode($error);
  exit;
}

?>
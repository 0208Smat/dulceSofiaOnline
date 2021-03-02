<?php
function emptyInputLogin($username, $password){
  $result;
  if($username == "" || $password == ""){
    $result = true;
  }else {
    $result = false;
  }
  //header("location: ../login.php?username=".$username." password=".$password);
  return $result;
}

function logInUser($conn, $username, $password){
  $uName = $_POST['username'];
  $uPass = $_POST['password'];

  $sql="select * from users where user_name='".$uName."' and user_password='".$uPass."' limit 1";
  $result =  $conn->query($sql);

  if ($result->num_rows == 1) {
    // output data of each row
    //echo "Ingreso exitoso";
    session_start();
    if($row = $result->fetch_assoc()) {
        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        $_SESSION["userid"] = $row["id"];
        $_SESSION["username"] = $row["user_name"];
        $_SESSION["password"] = $row["user_password"];
        header("location: ../index.php");
        exit();
    }
    //validar datos mensuales

  }else{
    echo "Combinacion de usuario y contraseña invalida.";
  }
}

function createSubject($conn, $name, $document_value, $address, $telephone, $cellphone){
  $sql="INSERT INTO subject (document_value, name, address, telephone, cellphone)
  VALUES ('$document_value','$name','$address','$telephone','$cellphone')";

  if ($conn->query($sql) === TRUE) {
    header("location: ../subject_creation.php?creation=ok");
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function deleteSubject($conn, $subject_id){
  $sql="DELETE FROM subject WHERE id = $subject_id";

  if ($conn->query($sql) === TRUE) {
    header("location: ../subject.php?deletion=ok");
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function createProduct($conn, $description, $price, $cost){
  $sql = "INSERT INTO product (price, description, cost) VALUES ($price, '$description', $cost)";

  if ($conn->query($sql) === TRUE) {
    header("location: ../product_creation.php?creation=ok");
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function loadSelectedData($conn, $domainName,$domainId){//un used
  $product_id = '';
  $subject_id = '';
  switch ($domainName) {
    case 'subject':
      $sql = "SELECT id, name, document_value, address, telephone, cellphone, date(creation_timestamp) as creation_date FROM subject where id = $domainId";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            $subject_id = $row["id"];
            $name = $row["name"];
            $document_value = $row["document_value"];
            $address = $row["address"];
            $telephone = $row["telephone"];
            $cellphone = $row["cellphone"];
            $creation_date = $row["creation_date"];
          }
      }else{
        echo "subject not found with id ".$domainId;
      }
      break;
      case 'product':
        $sql = "SELECT id, description, price, date(creation_timestamp) as creation_date FROM product where id = $domainId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              $product_id = $row["id"];
              $description = $row["description"];
              $price = $row["price"];
              $creation_date = $row["creation_date"];
            }
        }else{
          echo "product not found with id ".$domainId;
        }
        break;
      default:
        echo "invalid domain: ".$domainName;
        exit();
        break;
  }
  $conn->close();
}

function updateDomainRow($conn, $domainName, $domainId){//unused
  switch ($domainName) {
    case 'subject':
      $subject_id = $_POST['id'];
      $name = $_POST["name"];
      $document_value = $_POST["document_value"];
      $address = $_POST["address"];
      $telephone = $_POST["telephone"];
      $cellphone = $_POST["cellphone"];

      $sql = "UPDATE subject set name = '$name', document_value = '$document_value', address = '$address', telephone = '$telephone', ";
      $sql .= "cellphone = '$cellphone' where id = $subject_id";
      $result = $conn->query($sql);
      break;
    case 'product':
      $product_id = $_POST['id'];
      $description = $_POST["description"];
      $price = $_POST["price"];

      $sql = "UPDATE product set description = '$name', price = $price, last_update_timestamp = current_timestamp";
      $sql .= " where id = $product_id";
      $result = $conn->query($sql);
      break;
    default:
      echo "invalid domain: ".$domainName;
      break;
  }
  if ($result === TRUE) {
    header("location: ../".$domainName."_selected.php?edit=".$domainId."&editresult=ok");
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

function insertOrderHeader($conn, $subject_id, $total_order_amount, $total_order_gross_amount,$observation){
  $sql = "INSERT INTO orders (subject_id, gross_total, net_total, observation) VALUES ($subject_id, $total_order_gross_amount, $total_order_amount, '$observation')";
  $orderId = "";
  if ($conn->query($sql) === TRUE) {
    $orderId = $conn -> insert_id;
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  return $orderId;
}

function insertOrderDetail($conn, $orderId, $product_id, $product_description,
  $product_price, $product_cost,$product_quantity, $product_amount, $product_gross_amount){
    $sql = "INSERT INTO orders_detail (orders_id, product_id, product_description, price, cost,quantity, gross_amount, net_amount)
    VALUES ($orderId, $product_id, '$product_description', $product_price, $product_cost,$product_quantity,
      $product_gross_amount, $product_amount)";
    if ($conn->query($sql) != TRUE) {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }

function searchOrders($conn, $searchParams, $fromDate, $toDate){
  $sql = "SELECT o.id, s.name as subject_name, round(o.gross_total) as gross_total, round(o.net_total) as net_total,
   date(o.creation_timestamp) as creation_date FROM orders o join subject s on o.subject_id = s.id";
  $searchParams = strtoupper($searchParams);
  $sql .= " WHERE UPPER(CONCAT(s.name, o.net_total, o.gross_total)) like '%".$searchParams."%'";
  if($fromDate != "" && $toDate != ""){
    $sql .= "  AND date(o.creation_timestamp) BETWEEN '$fromDate' AND '$toDate'";
  }else{
    if($fromDate != ""){
      $sql .= " AND date(o.creation_timestamp) >= '$fromDate'";
    }else if($toDate != ""){
      $sql .= " AND date(o.creation_timestamp) <= '$toDate'";
    }
  }
  $sql .= " ORDER BY o.creation_timestamp DESC LIMIT 50";
  //echo "sql: $sql";
  // exit();
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["subject_name"]."</td>
        <td>".number_format($row["gross_total"],0,",",".").
        "<input type='hidden' class='gross_total' value='".$row["gross_total"]."'/></td>
        <td>".number_format($row["net_total"],0,",",".").
        "<input type='hidden' class='net_total' value='".$row["net_total"]."'/></td>
        <td>".$row["creation_date"]."</td>
        <td><a href='order_selected.php?order_id=".$row["id"]."' class='btn btn-info'>Ver</a></td>
        </tr>";
      }
  }else {
      //echo "sql: $sql";
      echo "<tr><td colspan='4'>Sin resultados</td></tr>";
  }
  $conn->close();
}

function deleteRow($conn, $domainName, $domainId, $returnPage, $mustDeleteDetails){
  $sql = "DELETE FROM $domainName WHERE id = $domainId";
  if ($conn->query($sql) != TRUE) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }else{
    if($mustDeleteDetails == "true"){
      $sql = "DELETE FROM orders_detail WHERE orders_id = $domainId";
      if ($conn->query($sql) != TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
      }
    }
    header("location: ../".$returnPage."?deletion=ok");
  }
}

function getCurrentMonthlySalesAmount($conn){
  $sql = "SELECT sum(net_total) as total FROM orders
WHERE YEAR(creation_timestamp) = YEAR(CURRENT_DATE)
AND MONTH(creation_timestamp) = MONTH(CURRENT_DATE);";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        return number_format($row["total"],0,",",".");
      }
  }else {
      return "Sin resultados";
  }
}

function getData($conn, $field, $table, $whereClause, $mustFormat){
  $sql = "SELECT $field FROM $table WHERE $whereClause";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        if($mustFormat == "true"){
            return number_format($row[$field],0,",",".");
        }else{
          return $row[$field];
        }
      }
  }else {
      return "Sin resultados";
  }
}

<?php

if(isset($_POST['save']) && isset($_POST['domain'])){
  $domainName = $_POST['domain'];
  require_once 'dbh.inc.php';
  require_once 'functions.inc.php';
  switch ($domainName) {
    case 'subject':
      if($_POST['subject_name'] == ""){
        header("location: ../subject_creation.php?error=emptyname");
      }else{
        $name = $_POST['subject_name'];
        $document_value = $_POST['document_value'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];
        $cellphone = $_POST['cellphone'];
        createSubject($conn, $name, $document_value, $address, $telephone, $cellphone);
      }
      break;
    case 'orders':
      if($_POST['total_order_amount'] == "0"){
        header("location: ../order_creation.php?order_for_subject=".$_POST['subject_id']."&name=".$_POST['subject_name']."&error=zeroamount");
      }else{
        $orderId = insertOrderHeader($conn, $_POST['subject_id'], $_POST['total_order_amount'], $_POST['total_order_gross_amount'],$_POST['observation']);
        foreach($_POST['product_id'] as $key => $value) {
          //solo insertamos si su cantidad es mayor a 0, se valida en js
          if($_POST['product_quantity'][$key] != "0"){
            insertOrderDetail($conn, $orderId, $_POST['product_id'][$key], $_POST['product_description'][$key],
              $_POST['product_price'][$key], $_POST['product_cost'][$key],$_POST['product_quantity'][$key],
              $_POST['product_amount'][$key], $_POST['product_gross_amount'][$key]);
          }
        }
        header("location: ../order_creation.php?order_for_subject=".$_POST['subject_id']."&name=".$_POST['subject_name']."&ordercreation=ok");
      }
      break;

    default:
      echo "invalid domain: ".$domainName;
      exit();
      break;
  }
  exit();
}

if(isset($_GET['delete'])){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    deleteSubject($conn, $_GET['delete']);
}

if(isset($_POST['delete']) && isset($_POST['domain_name']) && isset($_POST['domain_id'])){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if(isset($_POST["delete_details"])){
        deleteRow($conn, $_POST['domain_name'], $_POST['domain_id'], "orders.php", $_POST["delete_details"]);
    }else{
        deleteRow($conn, $_POST['domain_name'], $_POST['domain_id'], "orders.php");
    }
    // switch ($_POST['domain_name']) {
    //   case 'orders':
    //     deleteRow($conn, $_POST['domain_name'], $_POST['domain_id']);
    //     break;
    //
    //   default:
    //     echo "invalid domain name: ".$_POST['domain_name'];
    //     break;
    // }
    //deleteSubject($conn, $_POST['delete']);
}

if(isset($_GET['edit']) && isset($_GET['domain'])){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    $domainName = $_GET['domain'];
    $domainId = $_GET['edit'];
    switch ($domainName) {
        case 'product':
          $sql = "SELECT id, description, price, cost, date(creation_timestamp) as creation_date FROM product where id = $domainId";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $product_id = $row["id"];
                $description = $row["description"];
                $price = $row["price"];
                $cost = $row["cost"];
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
  //  $conn->close();
}

if(isset($_POST['update']) && isset($_POST['domain'])){
  require_once 'dbh.inc.php';
  $domainId = $_POST['id'];
  $domainName = $_POST['domain'];
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
      $cost = $_POST["cost"];

      $sql = "UPDATE product set description = '$description', price = $price, cost = $cost, last_update_timestamp = current_timestamp";
      $sql .= " where id = $product_id";
      $result = $conn->query($sql);
      break;
    default:
      echo "invalid domain: ".$domainName;
      break;
  }
  if ($result === TRUE) {
    header("location: ../".$domainName."_selected.php?edit=".$domainId."&domain=".$domainName."&editresult=ok");
  }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

if(isset($_POST['saveProduct'])){
  //validacion de campos
  if($_POST['description'] == ""){
    header("location: ../product_creation.php?error=emptyname");
  }else if($_POST['price'] == ""){
    header("location: ../product_creation.php?error=emptyprice");
  }else{
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $description = $_POST['description'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];

    createProduct($conn, $description, $price, $cost);
  }
  exit();
}

if(isset($_GET['search']) && isset($_GET['domain'])){
    header("location: ../".$_GET['domain'].".php?search_parameter=".$_GET['search_parameter']);
    exit();
}
if(isset($_POST['action'])){
    //header("location: ../orders.php?search_parameter=".$_GET['search_parameter']);
    if($_POST['action'] == "search_orders"){
      require_once 'dbh.inc.php';
      require_once 'functions.inc.php';

      searchOrders($conn, $_POST['search_parameter'], $_POST['from_date'], $_POST['to_date']);
    }
}

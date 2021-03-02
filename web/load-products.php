<?php
  include 'includes/dbh.inc.php';

  if(isset($_POST["action"])){
    switch ($_POST["action"]) {
      case 'searchProductToAdd':
        $sql = "SELECT id, description, price, cost  FROM product";
        if(isset($_POST["search_parameter"])){
            $param = strtoupper($_POST["search_parameter"]);
            $sql .= " WHERE UPPER(CONCAT(description, price)) like '%".$param."%'";
        }
        $sql .= " ORDER BY description LIMIT 50";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()){
            echo "<tr id = '".$row["id"]."' class='productRow'><td>".$row["description"]."</td>
            <td class='priceContainer'>".number_format($row["price"],0,",",".")."</td>
            <td class='costContainer'>".number_format($row["cost"],0,",",".")."</td>
            <td><a class='btn btn-success addButton' style='color: #fff;' onclick='addToOrder(this);'>Agregar</a></td>
            </tr>";
          }
        }else {
            echo "0 results";
        }
        break;

        case 'addProduct':
          if(isset($_POST["selected_product_id"]) && isset($_POST["selected_product_ids"])){
            //$product_id = $_POST["selected_product_id"];
            $product_id = $_POST["selected_product_ids"];
            //$sql = "SELECT id, description, price FROM product WHERE id = $product_id";
            $sql = "SELECT id, description, price, cost FROM product WHERE id in ($product_id) ORDER BY description";
            $result = $conn->query($sql);
//PASO FINAL CON PHP NORMAL
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()){
                  echo "<tr id = '".$row["id"]."' class='productRow'>
                  <td style='display:none;'>
                  <input name='product_id[]' value='".$row["id"]."'/>
                  <input name='product_price[]' value='".$row["price"]."'/>
                  <input name='product_cost[]' value='".$row["cost"]."'/>
                  <input name='product_gross_amount[]' value='0' class='totalGrossAmountInput'/>
                  <input name='product_amount[]' value='0' class='totalAmountInput'/>
                  <input name='product_description[]' value='".$row["description"]."'/>
                  </td>
                  <td>".$row["description"]."</td>
                  <td class='priceContainer'>".number_format($row["price"],0,",",".")."</td>
                  <td class='costContainer'>".number_format($row["cost"],0,",",".")."</td>
                  <td><a class='btn btn-light' onclick='alterQuantity(this);'>-</a>
                  <input name='product_quantity[]' type='number' class='smallInput' onkeyup='validateQuantity(this);' value='0'/>
                  <a class='btn btn-light' onclick='alterQuantity(this);'>+</a></td>
                  <td class='totalGrossAmountContainer'>0</td>
                  <td class='totalAmountContainer'>0</td>
                  <td><a class='btn btn-danger' onclick='deleteRow(this);' style='color: #fff;'>Eliminar</a></td>
                  </tr>";
              }
            }else {
                echo "0 results";
            }
          }else{
            echo "post variable selected_product_id not set";
            exit();
          }
        break;

      default:
        echo "Invalid action value: ".$_POST["action"];
        exit();
        break;
    }
  }
  $conn->close();
?>

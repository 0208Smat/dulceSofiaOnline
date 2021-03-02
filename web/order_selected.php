<?php
  include_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Dulce Sofia</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- owl css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- awesome fontfamily -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <script src="js/myjs.js"></script>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
    <div class="wrapper">
    <div id="content">
      <div class="bg_bg">
        <!-- about -->
        <div class="about" style="background-color:white">
          <div class="container" style="margin-top:45px;">
            <div class="row">
              <div class="col-md-12">
                <h1 align="center">Datos de pedido seleccionado</h1>
                <!-- tabla de datos de cliente -->
                <!-- datos de cabecera -->
                <table align="center" class="table">
                  <?php
                    require_once 'includes/dbh.inc.php';
                    $sql = "SELECT net_total, gross_total, date(creation_timestamp) as creation_date, coalesce(observation,'') as observation FROM orders WHERE id = ".$_GET["order_id"];
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        if($row = $result->fetch_assoc()) {
                          echo "<tr><td align='center' style='font-size: x-large;'>
                          Total Bruto:<span class='generalAmount'>
                          ".number_format($row["gross_total"],0,",",".")." Gs.
                          </span>
                          Total Neto:<span class='generalAmount'>
                          ".number_format($row["net_total"],0,",",".")." Gs.
                          </span>
                          Fecha Pedido: ".$row["creation_date"]."
                          </td></tr>";

                          if($row["observation"] != ""){
                            echo "<tr><td align='center' style='font-size: x-large;'>
                            Observación: ".$row["observation"]."
                            </td></tr>";
                          }
                        }
                    }else {
                        echo "0 results";
                    }
                  ?>
                </table>
                  <table align="center" class="table" style="margin-bottom:0;">
                    <caption class="myCaption">Datos de cliente:</caption>
                    <tbody id="subjectDataTbody">
                      <?php
                        require_once 'includes/dbh.inc.php';
                        $sql = "SELECT s.id as subject_id, s.name, s.document_value, s.address, s.telephone, s.cellphone, date(s.creation_timestamp)
                         as creation_date from orders o join subject s on o.subject_id = s.id where o.id = ".$_GET["order_id"];
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            if($row = $result->fetch_assoc()) {
                              echo "<tr>
                              <td class='myBold'>Nombre:</td><td>".$row["name"]."</td>
                              <td class='myBold'>Documento:</td><td>".$row["document_value"]."</td>
                              </tr>
                              <tr>
                              <td class='myBold'>Dirección:</td><td>".$row["address"]."</td>
                              <td class='myBold'>Teléfono:</td><td>".$row["telephone"]."</td>
                              </tr>
                              <tr>
                              <td class='myBold'>Celular:</td><td>".$row["cellphone"]."</td>
                              <td class='myBold'>Fecha de Creación:</td><td>".$row["creation_date"]."</td>
                              </tr>";
                              $sql = "SELECT count(*) as quantity, coalesce(AVG(gross_total),0) as gross_average, coalesce(AVG(net_total),0) as net_average FROM orders WHERE
                               YEAR(creation_timestamp) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(creation_timestamp) =
                                MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
                                and subject_id = ".$row["subject_id"];
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                if($row = $result->fetch_assoc()) {
                                  echo "<tr>
                                  <td class='myBold'>Cantidad pedidos mes pasado:</td><td>".$row["quantity"]."</td>
                                  <td class='myBold'>Promedio bruto mes pasado:</td><td>".number_format($row["gross_average"],0,",",".")."</td>
                                  </tr>";
                                  echo "<tr>
                                  <td></td><td></td>
                                  <td class='myBold'>Promedio neto mes pasado:</td><td>".number_format($row["net_average"],0,",",".")."</td>
                                  </tr>";
                                }
                              }
                            }
                        }else {
                            echo "Error al traer datos de cliente";
                        }
                      ?>
                    </tbody>
                  </table>
                  <!-- detalles -->
                <table align="center" class="table">
                  <caption class="myCaption">Detalles de pedido:</caption>
                  <thead align="center">
                    <tr>
                      <th>Descripción</th>
                      <th>Precio</th>
                      <th>Costo</th>
                      <th>Cantidad</th>
                      <th>Monto Bruto</th>
                      <th>Monto Neto</th>
                    </tr>
                  </thead>
                  <tbody align="center">
                  <?php
                    require_once 'includes/dbh.inc.php';
                    $sql = "SELECT product_description, price, cost, quantity, gross_amount, net_amount FROM orders_detail WHERE orders_id = ".$_GET["order_id"];
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                          echo "<tr><td>".$row["product_description"]."</td>
                          <td>".number_format($row["price"],0,",",".")."</td>
                          <td>".number_format($row["cost"],0,",",".")."</td>
                          <td>".number_format($row["quantity"],0,",",".")."</td>
                          <td>".number_format($row["gross_amount"],0,",",".")."</td>
                          <td>".number_format($row["net_amount"],0,",",".")."</td>
                          </tr>";
                        }
                    }else {
                        echo "0 results";
                    }
                    $conn->close();
                  ?>
                  </tbody>
                </table>
                <form method="POST" action="includes/process.inc.php" onsubmit="return confirmDelete()">
                  <table class="table">
                    <tr>
                      <td align="right">
                        <!-- href="orders.php?deletion=ok" -->
                        <input type="hidden" name="domain_id" value="<?php echo $_GET["order_id"];?>"/>
                        <input type="hidden" name="domain_name" value="orders"/>
                        <input type="hidden" name="delete_details" value="true"/>
                        <button class="btn btn-danger" type="submit" name="delete">Eliminar Pedido</button>
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
   <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

</body>

</html>

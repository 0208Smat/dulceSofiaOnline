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
    <script>
      $(document).ready(function(){
        $("#searchButton").click(function(){
          fireSearchOrders();
        })
      });
    </script>

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
                <?php
                  if(isset($_GET["deletion"])){
                      echo "<div class='alert alert-danger'>
                        Pedido eliminado exitosamente.
                      </div>";

                  }
                ?>
                <!-- <form method="GET" action="includes/process.inc.php" style="margin-top:1rem;"> -->
                  <table align="center" class="table" style="margin-bottom:0;">
                    <tr>
                      <td>
                        <span style="font-weight: bold; font-size: large;">Total Bruto: </span>
                      </td>
                      <td>
                        <span class="generalAmount" id="grossAmountContainer">0</span>
                      </td>
                      <td>
                        <span style="font-weight: bold; font-size: large;">Total Neto: </span>
                      </td>
                      <td>
                        <span class="generalAmount" id="generalAmountContainer">0</span>
                      </td>
                      <!-- <td colspan="4">
                          <span style="font-weight: bold; font-size: large;">Total Bruto: </span>
                          <span class="generalAmount" id="grossAmountContainer">0</span>

                          <span style="font-weight: bold; font-size: large;">Total Neto: </span>
                          <span class="generalAmount" id="generalAmountContainer">0</span>
                      </td> -->
                    </tr>
                    <tr>
                      <td>
                          <span style="font-weight: bold; font-size: large;">Cantidad: </span>
                      </td>
                      <td>
                        <span class="generalAmount" id="quantityContainer">0</span>
                      </td>
                      <td>
                          <span style="font-weight: bold; font-size: large;">Promedio Bruto: </span>
                      </td>
                      <td>
                        <span class="generalAmount" id="grossAverageContainer">0</span>
                      </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        </td>
                        <td>
                          <span style="font-weight: bold; font-size: large;">Promedio Neto: </span>
                        </td>
                        <td>
                          <span class="generalAmount" id="netAverageContainer">0</span>
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <label style="font-weight: bold;font-size: large;">
                          Desde <input id="from_date" type="date" class="form-control"
                          style="margin-bottom:0px; display:inherit; width:auto;"/>
                        </label>
                      </td>
                      <td colspan="2">
                        <label style="font-weight: bold;font-size: large;">
                          Hasta <input id="to_date" type="date" class="form-control"
                          style="margin-bottom:0px; display:inherit; width:auto;"/>
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" style="vertical-align:middle;">
                          <input style="display: inline-block;width: 75%;margin: 0px;padding: 0px;" id="search_param"
                          type="text" name="search_parameter" class="form-control" placeholder="Buscar pedidos...">
                          <button id="searchButton" type="submit" name="search_orders" class="btn btn-primary"
                          style='width: 25%;float: right;'>
                            Buscar
                          </button>
                      </td>
                    </tr>
                  </table>
                <!-- </form> -->
                <table align="center" class="table">
                  <thead align="center">
                    <tr>
                      <th>Cliente</th>
                      <th>Total Bruto</th>
                      <th>Total Neto</th>
                      <th>Fecha</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody id="searchResultTbody" align="center">
                  <?php
                    require_once 'includes/dbh.inc.php';
                    $sql = "SELECT o.id, s.name as subject_name, o.gross_total, o.net_total, date(o.creation_timestamp) as creation_date FROM orders o join subject s on o.subject_id = s.id";
                    if(isset($_GET["search_parameter"])){
                        $param = strtoupper($_GET["search_parameter"]);
                        $sql .= " WHERE UPPER(CONCAT(s.name, o.net_total, o.creation_date)) like '%".$param."%'";
                    }
                    $sql .= " ORDER BY o.creation_timestamp DESC LIMIT 50";
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
                        echo "<script>validateGeneralAmount();</script>";
                    }else {
                        echo "<tr><td colspan='4'>Sin resultados</td></tr>";
                    }
                    $conn->close();
                  ?>
                  </tbody>
                </table>
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

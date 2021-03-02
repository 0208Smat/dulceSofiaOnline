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
    <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
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

    <!-- footer -->
    <fooetr>
        <div class="about" style="background-color:white">
            <div class="container-fluid">
                <div class="row">
                  <!-- poner detalles cargados en un div desplegable y buscador mas abajo -->
                  <div class="container" style="margin-top: 50px;">
                    <?php
                      if(isset($_GET["ordercreation"])){
                          echo "<div class='alert alert-success'>
                            Pedido creado exitosamente.
                          </div>";
                      }
                      if(isset($_GET["error"])){
                        if($_GET["error"] == "zeroamount"){
                          echo "<div class='alert alert-danger'>
                            El pedido no puede valer 0 Gs.
                          </div>";
                        }
                      }
                      require_once "includes/process.inc.php";
                    ?>
                    <h2>Pedido para cliente: <strong><?php echo $_GET['name'];?></strong></h2>
                    <div class="btn btn-light" style="width:100%;">
                      <p onclick="toggleTable(this.parentNode);" style="font-weight: bold;
    font-size: 25px;">Productos Agregados</p><br />
                      <form  method="POST" action="includes/process.inc.php">
                        <input id="obsInput" type="text" name="observation" placeholder="Observación (opcional)..." style="
                          height: 100%; width: 100%;" class="form-control">
                        <table class="table" align="center">
                        <thead>
                          <tr>
                            <th>
                              Producto
                            </th>
                            <th>
                              Precio
                            </th>
                            <th>
                              Costo
                            </th>
                            <th>
                              Cantidad
                            </th>
                            <th>
                              Monto Bruto
                            </th>
                            <th>
                              Monto Neto
                            </th>
                            <th>
                              Acción
                            </th>
                          </tr>
                        </thead>
                        <tbody id="selectedProductsTbody">
                          <!-- cargar detalles por php jquery -->
                        </tbody>
                        <tfoot>
                          <tr>
                            <td style="display:none;">
                                <input id="totalOrderInput" name='total_order_amount' type="number" value='0'/>
                                <input id="totalGrossOrderInput" name='total_order_gross_amount' type="number" value='0'/>
                                <input name='subject_id' value="<?php echo $_GET["order_for_subject"];?>"/>
                                <input name='subject_name' value="<?php echo $_GET["name"];?>"/>
                                <input name='domain' value="orders"/>
                            </td>
                            <td colspan="4">
                              <p style="font-weight: bold;">Monto Total Bruto:
                                <strong class="generalAmount" id="totalGrossOrderContainer">0 Gs.</strong>
                              </p>
                              <p style="font-weight: bold;">Monto Total Neto:
                                <strong class="generalAmount" id="totalOrderContainer">0 Gs.</strong>
                              </p>
                            </td>
                            <td>
                                <button class='btn btn-success' type='submit' name='save' style='color: #fff;'>Guardar Pedido</button>
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                      </form>
                    </div>
                    <div class="container">
                      <!-- busqueda de productos para agregar a pedido -->
                      <!-- <form method="GET" action="includes/process.inc.php" style="margin-top:1rem;"> -->
                        <table align="center" class="table" style="margin-bottom:0;">
                          <tr>
                            <td style="vertical-align:middle;">
                                <input type="hidden" name="domain" value="product"/>
                                <input style="padding:0px;margin:0px;" type="text" name="search_parameter" id="searchParam" class="form-control" placeholder="Buscar productos...">
                            </td>
                            <td>
                              <!-- type="submit" -->
                                <button id="searchButton"  name="search" class="btn btn-primary" style='width:100%;'>Buscar</button>
                            </td>
                          </tr>
                        </table>
                      <!-- </form> -->
                      <table align="center" class="table">
                        <thead align="center">
                          <tr>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Costo</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <tbody align="center" id ="searchResultTbody">
                        <?php
                        // busqueda inicial
                          require_once 'includes/dbh.inc.php';
                          $sql = "SELECT id, description, price, cost FROM product ORDER BY description LIMIT 50";
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()){
                              echo "<tr id = '".$row["id"]."' class='productRow'><td>".$row["description"]."</td>
                              <td class='priceContainer'>".number_format($row["price"],0,",",".")."</td>
                              <td class='costContainer'>".number_format($row["cost"],0,",",".")."</td>
                              <td><a class='btn btn-success addButton' style='color: #fff;'>Agregar</a></td>
                              </tr>";
                            }
                          }else {
                              echo "0 results";
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
    </fooetr>
    <!-- end footer -->

    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/myjs.js"></script>
    <script src="js/myjsProduct.js"></script>
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

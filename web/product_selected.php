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
        <div class="footer" style="margin-top: 0px;background-color: white;">
          <div class="container" style="margin-top:45px;">
            <?php
              if(isset($_GET["deletion"])){
                  echo "<div class='alert alert-danger'>
                    Producto eliminado exitosamente.
                  </div>";
              }
              if(isset($_GET["editresult"])){
                if($_GET["editresult"] == "ok"){
                  echo "<div class='alert alert-info'>
                    Producto editado exitosamente.
                  </div>";
                }else{
                  echo "<div class='alert alert-danger'>
                    Ocurrio un error inesperado al actualizar el producto. Comunique al administrador.
                  </div>";
                }
              }
              require_once "includes/process.inc.php";
            ?>
            <div class="row">
              <div class="col-md-12">
                <form method="POST" action="includes/process.inc.php">
                  <table align="center" class="table" style="margin-bottom:0;">
                    <caption class="myCaption">Datos de producto:</caption>
                    <tbody id="subjectDataTbody">
                      <?php
                        require_once 'includes/dbh.inc.php';
                        $sql = "SELECT description, round(price) as price, round(cost) as cost, date(creation_timestamp)
                         as creation_date from product where id = ".$_GET["edit"];
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            if($row = $result->fetch_assoc()) {
                              echo "<tr>
                              <td class='myBold middleVerticalAlign'>Descripcion:</td>
                              <td>
                              <input disabled name='description' class='form-control smallFormControl myinput' value='".$row["description"]."'/>
                              </td>
                              <td class='myBold middleVerticalAlign'>Precio:</td>
                              <td>
                              <input disabled name='price' class='form-control smallFormControl myinput' value='".$row["price"]."' onkeyup='displayFormatedNumber(this);'/>
                              <p class='formatedNumber' style='font-size: 45px;'></p>
                              </td>
                              </tr>
                              <tr>
                              <td class='myBold middleVerticalAlign'>Costo:</td>
                              <td>
                              <input disabled name='cost' class='form-control smallFormControl myinput' value='".$row["cost"]."' onkeyup='displayFormatedNumber(this);'/>
                              <p class='formatedNumber' style='font-size: 45px;'></p>
                              </td>
                              <td class='myBold middleVerticalAlign'>Fecha Creación:</td>
                              <td>".$row["creation_date"]."</td>
                              </tr>";
                              echo "<tr>
                                <td class='myHide'>
                                  <input type='hidden' value='product' name='domain'>
                                  <input type='hidden' value=".$_GET["edit"]." name='id'>
                                </td>
                                <td align='right' colspan='4'>
                                    <button id='updateButton' class='btn btn-info myHide' name='update' type='submit'>Actualizar</button>
                                    <button id='editButton' type='button' class='btn btn-info' onclick='toggleEditElements();'>Editar</button>
                                  </div>
                                </td>
                              </tr>";
                            }
                        }else {
                            echo "Error al traer datos de producto";
                        }
                      ?>
                    </tbody>
                  </table>
                </form>
                <h1 align="center">Datos de ventas del producto:</h1>
                  <table class="table" style="display: inline-block; width: 45%;">
                    <caption class="myCaption">
                      Mejores compradores
                    </caption>
                    <thead align="center">
                      <tr>
                        <th>
                          Nombre
                        </th>
                        <th>
                          Cantidad
                        </th>
                        <th>
                          Total Bruto
                        </th>
                        <th>
                          Total Neto
                        </th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        require_once 'includes/dbh.inc.php';
                        $sql = "SELECT s.name as subject_name, sum(od.quantity) as quantity, sum(od.gross_amount) as gross_amount,
                        sum(od.net_amount) as net_amount from orders o join orders_detail od on od.orders_id = o.id
                        join subject s on o.subject_id = s.id where od.product_id = ".$_GET["edit"]." GROUP by 1 order by 4 desc, 3 desc";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                              echo "<tr>
                              <td>".$row["subject_name"]."</td>
                              <td>".number_format($row["quantity"],0,",",".")."</td>
                              <td>".number_format($row["gross_amount"],0,",",".")."</td>
                              <td>".number_format($row["net_amount"],0,",",".")."</td>
                              </tr>";
                            }
                        }
                      ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
        <!-- end about -->
    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/myjs.js"></script>
    <script src="js/myjsProduct.js"></script>
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

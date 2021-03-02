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
    <div id="content" style="background-color:white">
      <div class="bg_bg" style="background-color:white">
        <!-- about -->
        <div class="about" style="margin-top:0px;background-color:white">
          <div class="container" style="margin-top:45px;" style="background-color:white">
            <?php
              if(isset($_GET["deletion"])){
                  echo "<div class='alert alert-danger'>
                    Cliente eliminado exitosamente.
                  </div>";
              }
              if(isset($_GET["editresult"])){
                if($_GET["editresult"] == "ok"){
                  echo "<div class='alert alert-info'>
                    Cliente editado exitosamente.
                  </div>";
                }else{
                  echo "<div class='alert alert-danger'>
                    Ocurrio un error inesperado al actualizar el cliente. Comunique al administrador.
                  </div>";
                }
              }
            ?>
            <div class="row" >
              <div class="col-md-12">
                <form method="POST" action="includes/process.inc.php">
                  <table align="center" class="table" style="margin-bottom:0;">
                    <caption class="myCaption">Datos de cliente:</caption>
                    <tbody id="subjectDataTbody">
                      <?php
                        require_once 'includes/dbh.inc.php';
                        $sql = "SELECT s.name, s.document_value, s.address, s.telephone, s.cellphone, date(s.creation_timestamp)
                         as creation_date from subject s where id = ".$_GET["edit"];
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            if($row = $result->fetch_assoc()) {
                              echo "<tr>
                              <td class='myBold middleVerticalAlign'>Nombre:</td>
                              <td><input disabled name='name' class='form-control smallFormControl myinput' value='".$row["name"]."'/></td>
                              <td class='myBold middleVerticalAlign'>Documento:</td>
                              <td><input disabled name='document_value' class='form-control smallFormControl myinput' value='".$row["document_value"]."'/></td>
                              </tr>
                              <tr>
                              <td class='myBold middleVerticalAlign'>Dirección:</td>
                              <td><input disabled name='address' class='form-control smallFormControl myinput' value='".$row["address"]."'/></td>
                              <td class='myBold middleVerticalAlign'>Teléfono:</td>
                              <td><input disabled name='telephone' class='form-control smallFormControl myinput' value='".$row["telephone"]."'/></td>
                              </tr>
                              <tr>
                              <td class='myBold middleVerticalAlign'>Celular:</td>
                              <td><input disabled name='cellphone' class='form-control smallFormControl myinput' value='".$row["cellphone"]."'/></td>
                              <td class='myBold middleVerticalAlign'>Fecha de Creación:</td>
                              <td>".$row["creation_date"]."</td>
                              </tr>";
                              echo "<tr>
                                <td class='myHide'>
                                  <input type='hidden' value='subject' name='domain'>
                                  <input type='hidden' value=".$_GET["edit"]." name='id'>
                                </td>
                                <td align='right' colspan='4'>
                                    <a href='order_creation.php?order_for_subject=".$_GET["edit"]."&name=".$row["name"]."' class='btn btn-success'>Crear pedido para cliente</a>
                                    <button id='updateButton' class='btn btn-info myHide' name='update' type='submit'>Actualizar</button>
                                    <button id='editButton' type='button' class='btn btn-info' onclick='toggleEditElements();'>Editar</button>
                                  </div>
                                </td>
                              </tr>";
                            }
                        }else {
                            echo "Error al traer datos de cliente";
                        }
                      ?>
                    </tbody>
                  </table>
                </form>
                <div class="container">
                  <h2>Datos de ventas al cliente</h2>
                    <table class="table" style="display: inline-block; width: 45%;">
                      <caption class="myCaption">
                        Pedidos mes pasado
                      </caption>
                      <thead align="center">
                        <tr>
                          <th>
                            Cantidad pedidos
                          </th>
                          <th>
                            Monto promedio
                          </th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          require_once 'includes/dbh.inc.php';
                          $sql = "SELECT count(*) as quantity, coalesce(AVG(net_total),0) as average FROM orders WHERE
                           YEAR(creation_timestamp) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(creation_timestamp) =
                            MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
                            and subject_id = ".$_GET["edit"];
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) {
                              if($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>".$row["quantity"]."</td>
                                <td>".number_format($row["average"],0,",",".")."</td>
                                </tr>";
                              }
                          }
                        ?>
                      </tbody>
                    </table>
                    <table class="table" style="float: right; width: 45%;">
                      <caption class="myCaption">
                        Productos más comprados actualmente
                      </caption>
                      <thead align="center">
                        <tr>
                          <th>
                            Descripción
                          </th>
                          <th>
                            Cantidad
                          </th>
                          <th>
                            Monto Total
                          </th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          require_once 'includes/dbh.inc.php';
                          $sql = "SELECT od.product_description as description, sum(od.quantity) as quantity, sum(od.net_amount) as amount
                          FROM orders_detail od join orders o on od.orders_id = o.id WHERE o.subject_id = ".$_GET["edit"]." group by 1 order by 2 desc, 1";
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>".$row["description"]."</td>
                                <td>".number_format($row["quantity"],0,",",".")."</td>
                                <td>".number_format($row["amount"],0,",",".")."</td>
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
        </div>
        <!-- end about -->
    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <script src="js/myjs.js"></script>
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

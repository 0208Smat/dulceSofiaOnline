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
        <div class="about" style="background-color:white;">
          <div class="container" style="margin-top:75px;">
            <a href="subject_creation.php" class='btn btn-success'>Crear Cliente</a>
            <?php
              if(isset($_GET["deletion"])){
                  echo "<div class='alert alert-danger'>
                    Cliente eliminado exitosamente.
                  </div>";

              }
            ?>
            <div class="row">
              <div class="col-md-12">
                <form method="GET" action="includes/process.inc.php" style="margin-top:1rem;">
                  <table align="center" class="table" style="margin-bottom:0;">
                    <tr>
                      <td style="vertical-align:middle;">
                          <input type="hidden" name="domain" value="subject"/>
                          <input style="padding:0px;margin:0px;" type="text" name="search_parameter" class="form-control" placeholder="Buscar clientes...">
                      </td>
                      <td>
                          <button type="submit" name="search" class="btn btn-primary" style='width:100%;' >Buscar</button>
                      </td>
                    </tr>
                  </table>
                </form>
                <table align="center" class="table">
                  <thead align="center">
                    <tr>
                      <th>Nombre</th>
                      <th>Documento</th>
                      <th>Dirección</th>
                      <th>Teléfono</th>
                      <th>Celular</th>
                      <th colspan="2">Acción</th>
                    </tr>
                  </thead>
                  <tbody align="center">
                  <?php
                    require_once 'includes/dbh.inc.php';
                    $sql = "SELECT id, name, document_value, address, telephone, cellphone FROM subject";
                    if(isset($_GET["search_parameter"])){
                        $param = strtoupper($_GET["search_parameter"]);
                        $sql .= " WHERE UPPER(CONCAT(name, coalesce(document_value,''), coalesce(address,''), coalesce(cellphone,''), coalesce(telephone,''))) like '%".$param."%'";
                    }
                    $sql .= " ORDER BY creation_timestamp DESC LIMIT 50";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                          echo "<tr><td>";
                          if(isset($name)){
                            echo "<input type='text' name='subject_name' value=".$name.">";
                          }else{
                            echo $row["name"];
                          }
                          //todo hacer pagina de cliente individual, editar ahi
                          echo "</td>";
                          echo "<td>".$row["document_value"]."</td>
                          <td>".$row["address"]."</td>
                          <td>".$row["telephone"]."</td>
                          <td>".$row["cellphone"]."</td>
                          <td colspan='2'><a href='subject_selected.php?edit=".$row["id"]."&domain=subject' class='btn btn-info'>Ver</a>
                          <a style='display:none;' href='includes/process.inc.php?delete=".$row["id"]."' class='btn btn-danger'>Eliminar</a>
                          <a href='order_creation.php?order_for_subject=".$row["id"]."&name=".$row["name"]."' class='btn btn-success'>Crear Pedido</a></td>
                          </tr>";
                        }
                    }else {
                        echo "Sin resultados";
                    }
                    $conn->close();
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

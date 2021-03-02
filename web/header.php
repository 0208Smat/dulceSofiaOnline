<?php
  session_start();
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
    <!-- end loader -->

     <div class="sidebar">
            <!-- Sidebar  -->
            <nav id="sidebar">

                <div id="dismiss">
                    <i class="fa fa-arrow-left"></i>
                </div>

                <ul class="list-unstyled components">
                    <li >
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>
                    <li>
                        <a href="recipe.html">Recipe</a>
                    </li>
                    <li>
                        <a href="blog.html">Blog</a>
                    </li>
                    <li class="active">
                        <a href="contact.html">Contact Us</a>
                    </li>
                </ul>
            </nav>
        </div>
    <div id="content">
    <!-- header -->
    <header style="background-color: #c768c7; padding:0px;">
        <div class="container-fluid">
            <div class="row" style="background-color: #c768c7;">
                <div class="col-md-3">
                    <div class="full">
                        <!-- <a class="logo" href="index.php"><img src="images/logo.png" alt="#" /></a> -->
                        <a class="logo" href="index.php">
                          <img style="width:250px; height:120px;" src="images/logos/dulceSofiaPasteleriaArtesanal.jpg" alt="#" />
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="full">
                        <div class="right_header_info" style="padding: 50px 0 0;">
                            <ul>
                                <!-- <li class="dinone"><img style="margin-right: 15px;" src="images/mail_icon.png" alt="#"><a href="#">demo@gmail.com</a></li> -->
                                <li class="dinone"><img style="margin-right: 15px;height: 21px;position: relative;top: -2px;" src="images/location_icon.png" alt="#"><a href="#">Asunción, Paraguay</a></li>
                                <?php
                                  if(isset($_SESSION["userid"])){
                                    echo "<li class='dinone'><a href='subject.php'>CLIENTES</a></li>";
                                    echo "<li class='dinone'><a href='orders.php'>PEDIDOS</a></li>";
                                    echo "<li class='dinone'><a href='product.php'>PRODUCTOS</a></li>";
                                    echo "<li class='button_user'><a class='button' href='#'>Bienvenid@, ".$_SESSION["username"]."</a><a class='button active' href='includes/logout.inc.php'>Salir</a></li>";
                                  }else{
                                    echo "<li class='button_user'><a class='button active' style='background-color: pink; border-color: grey;' href='login.php'>Ingresar</a><a class='button' style='display:none;' href='#'>Registrarse</a></li>";
                                  }
                                ?>
                                <!-- <li>
                                    <button type="button" id="sidebarCollapse">
                                        <img src="images/menu_icon.png" alt="#">
                                    </button>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- end header -->
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

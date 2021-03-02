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

    <!-- footer -->
    <fooetr>
        <div class="footer" style="margin-top: 50px;background-color: #c768c7;">
            <div class="container-fluid">
                <div class="row">
                  <div class=" col-md-12">
                    <?php
                      if(isset($_GET["creation"])){
                          echo "<div class='alert alert-success'>
                            Producto creado exitosamente.
                          </div>";
                      }
                      if(isset($_GET["error"])){
                        if($_GET["error"] == "emptyname"){
                          echo "<div class='alert alert-danger'>
                            La descripcion no puede estar vacía.
                          </div>";
                        }
                        if($_GET["error"] == "emptyprice"){
                          echo "<div class='alert alert-danger'>
                            El precio no puede estar vacío.
                          </div>";
                        }
                      }
                    ?>
                    <h2>Creación<strong class="white"> de productos</strong></h2>
                  </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <form class="main_form" method="POST" action="includes/process.inc.php">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Descripcion" type="text" name="description">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <input class="form-control" placeholder="Precio" type="number" name="price" onkeyup="displayFormatedNumber(this);">
                                    <p class="formatedNumber" style="font-size: 45px; margin-bottom: 20px;"></p>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12"
                                style="margin-bottom: 20px;">
                                    <input class="form-control" placeholder="Costo" type="number" name="cost" onkeyup="displayFormatedNumber(this);">
                                    <p class="formatedNumber" style="font-size: 45px; margin-bottom: 20px;"></p>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <button class="send" name="saveProduct" type="submit">Guardar</button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="img-box">
                            <figure><img src="images/img.jpg" alt="img" /></figure>
                        </div>
                    </div>
                </div>
                <div class="row" style="display:none;">
                    <div class="col-md-12">
                        <div class="footer_logo">
                          <a href="index.html"><img src="images/logo1.jpg" alt="logo" /></a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="lik">
                            <li > <a href="index.html">Home</a></li>
                            <li> <a href="about.html">About</a></li>
                            <li> <a href="recipe.html">Recipe</a></li>
                            <li> <a href="blog.html">blog</a></li>
                            <li class="active"> <a href="contact.html">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="new">
                            <h3>Newsletter</h3>
                            <form class="newtetter">
                                <input class="tetter" placeholder="Your email" type="text" name="Your email">
                                <button class="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright" style="display:none;">
                <div class="container">
                    <p>© 2019 All Rights Reserved. Design by<a href="https://html.design/"> Free Html Templates</a></p>
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

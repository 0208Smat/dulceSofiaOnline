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
  <script>
    $(document).ready(function(){
      var isLogged = document.getElementById("isLogged").value;
      //alert("isLogged: "+isLogged);
      if(isLogged == "true"){
        var tableArray = document.getElementsByClassName("table");
        for(var i = 0; i < tableArray.length; i++){
          var table = tableArray[i];
          table.style.display = "inline-block";
        }
      }
    });
  </script>
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<!-- body -->

<body class="main-layout">
  <div class="wrapper">
    <div id="content" >
      <div class="bg_bg">
        <!-- about -->
        <div class="about" style="background-color: white;">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="title"style="padding-top: 75px;">
                  <!-- <i><img src="images/title.png" alt="#" /></i> -->
                    <?php
                      require_once "includes/dbh.inc.php";
                      require_once "includes/functions.inc.php";

                      if(isset($_SESSION["userid"])){
                        echo "<input type='hidden' id='isLogged' value='true'/>";
                        echo "<h2>Bienvenido al sistema de Dulce Sofía</h2>";
                        echo "<h1>Datos de ventas del mes</h1>";
                        echo "<h3 align='center'>
                        Total bruto: <strong class='generalAmount'>".getData($conn, "sum(gross_total)", "orders",
                        "YEAR(creation_timestamp) = YEAR(CURRENT_DATE) AND MONTH(creation_timestamp) = MONTH(CURRENT_DATE)", "true").
                        " Gs</strong>
                        Total neto: <strong class='generalAmount'>".getCurrentMonthlySalesAmount($conn)." Gs</strong>
                        </h3>";
                      }else{
                        echo "<input type='hidden' id='isLogged' value='false'/>";
                        echo "<h2>Click en Ingresar para acceder al sistema</h2>";
                      }
                    ?>
                    <!-- display: inline-block -->
                      <table class="table" style="display: none; width: 45%;">

                        <caption class="myCaption">
                          Mejores compradores
                        </caption>
                        <thead align="center">
                          <tr>
                            <th>
                              Nombre
                            </th>
                            <th>
                              Cantidad Pedidos
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
                            $sql = "SELECT o.subject_id,s.name, count(o.id) as quantity, sum(gross_total) as gross_total,sum(net_total) as net_total from orders o
                            join subject s on s.id = o.subject_id WHERE YEAR(o.creation_timestamp) = YEAR(CURRENT_DATE)
                            AND MONTH(o.creation_timestamp) = MONTH(CURRENT_DATE)
                            group by 1 order by net_total desc, quantity desc";

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                  echo "<tr>
                                  <td>".$row["name"]."</td>
                                  <td>".$row["quantity"]."</td>
                                  <td>".number_format($row["gross_total"],0,",",".")."</td>
                                  <td>".number_format($row["net_total"],0,",",".")."</td>
                                  </tr>";
                                }
                            }
                          ?>
                        </tbody>
                      </table>
                      <table class="table" style="display: none;float: right; width: 45%;">
                        <caption class="myCaption">
                          Productos más vendidos
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
                            $sql = "SELECT product_id, product_description, sum(quantity) as quantity, sum(gross_amount)
                            as gross_amount, sum(net_amount)
                            as net_amount from orders_detail WHERE YEAR(creation_timestamp) = YEAR(CURRENT_DATE)
                             AND MONTH(creation_timestamp) = MONTH(CURRENT_DATE)
                              group by 1 order by net_amount desc, quantity desc";

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                  echo "<tr>
                                  <td>".$row["product_description"]."</td>
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
        </div>
        <!-- end about -->

        <!-- blog -->
        <div class="blog" style="display:none;">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="title">
                  <i><img src="images/title.png" alt="#" /></i>
                  <h2>Our Blog</h2>
                  <span>when looking at its layout. The point of using Lorem</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
                <div class="blog_box">
                  <div class="blog_img_box">
                    <figure><img src="images/blog_img1.png" alt="#" />
                      <span>02 FEB 2019</span>
                    </figure>
                  </div>
                  <h3>Spicy Barger</h3>
                  <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form,
                    accompanied by English versions from the </p>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mar_bottom">
                <div class="blog_box">
                  <div class="blog_img_box">
                    <figure><img src="images/blog_img2.png" alt="#" />
                      <span>02 FEB 2019</span>
                    </figure>
                  </div>
                  <h3>Egg & Tosh</h3>
                  <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form,
                    accompanied by English versions from the </p>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="blog_box">
                  <div class="blog_img_box">
                    <figure><img src="images/blog_img3.png" alt="#" />
                      <span>02 FEB 2019</span>
                    </figure>
                  </div>
                  <h3>Pizza</h3>
                  <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form,
                    accompanied by English versions from the </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end blog -->

        <!-- Our Client -->
        <div class="Client" style="display:none;">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="title">
                  <i><img src="images/title.png" alt="#" /></i>
                  <h2>Our Client</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 offset-md-3">
                <div class="Client_box">
                  <img src="images/client.jpg" alt="#" />
                  <h3>Roock Due</h3>
                  <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don’t look even slightly believable. If you are going to use a
                    passage of Lorem Ipsum, you need to be sure there isn’t anything embarrassing hidden in the middle of text.</p>
                  <i><img src="images/client_icon.png" alt="#" /></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end Our Client -->
      </div>
      <!-- footer -->
      <fooetr style="display:none;">
        <div class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class=" col-md-12">
                <h2>Request A<strong class="white"> Call Back</strong></h2>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                <form class="main_form">
                  <div class="row">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                      <input class="form-control" placeholder="Name" type="text" name="Name">
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                      <input class="form-control" placeholder="Email" type="text" name="Email">
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                      <input class="form-control" placeholder="Phone" type="text" name="Phone">
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                      <textarea class="textarea" placeholder="Message" type="text" name="Message"></textarea>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                      <button class="send">Send</button>
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
            <div class="row">
              <div class="col-md-12">
                <div class="footer_logo">
                  <a href="index.html"><img src="images/logo1.jpg" alt="logo" /></a>
                </div>
              </div>
              <div class="col-md-12">
                <ul class="lik">
                  <li class="active"> <a href="index.html">Home</a></li>
                  <li> <a href="about.html">About</a></li>
                  <li> <a href="recipe.html">Recipe</a></li>
                  <li> <a href="blog.html">Blog</a></li>
                  <li> <a href="contact.html">Contact us</a></li>
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
          <div class="copyright">
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

  <style>
    #owl-demo .item {
      margin: 3px;
    }

    #owl-demo .item img {
      display: block;
      width: 100%;
      height: auto;
    }
  </style>


  <script>
    $(document).ready(function() {
      var owl = $('.owl-carousel');
      owl.owlCarousel({
        margin: 10,
        nav: true,
        loop: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 2
          },
          1000: {
            items: 5
          }
        }
      })
    })
  </script>

</body>

</html>

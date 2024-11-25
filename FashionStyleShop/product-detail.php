<?php
  require_once("admincp/database/database.php");
  if (isset($_GET['id'])) {
    $ProductID = $_GET['id'];
    $query_Products = "SELECT * FROM product where ID = $ProductID";
    $result_products = $mysqli->query($query_Products);
    $row_products = $result_products->fetch_assoc();


    $typeID = $row_products['TypeID'];
    $query_typeProduct = "SELECT * FROM typeproduct where ID  = $typeID";
    $result_typeProduct= $mysqli->query($query_typeProduct);
    $row_typeProduct = $result_typeProduct->fetch_assoc();

     // san pham tuong tu
     $query_relatedProducts = "SELECT * FROM product where TypeID = $typeID AND ID <> $ProductID";
     $result_relatedProducts = $mysqli->query($query_relatedProducts);
     // sản phảm random
     $query_randomProducts = "SELECT *
     FROM product
     where TypeID <> $typeID
     ORDER BY RAND()
     LIMIT 8  ";
     $result_randomProducts = $mysqli->query($query_randomProducts);
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Shop | Product Detail</title>

    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="css/jquery.simpleLens.css">
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <script src="https://kit.fontawesome.com/ff4b23649f.js" crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>
    <!-- wpf loader Two -->
    <div id="wpf-loader-two">
        <div class="wpf-loader-two-inner">
            <span>Loading</span>
        </div>
    </div>
    <!-- / wpf loader Two -->
    <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
    <!-- END SCROLL TOP BUTTON -->

    <?php
    include("pages/header.php");
    include("pages/menu.php");
    ?>
 

    <!-- product category -->
    <section id="aa-product-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-product-details-area">
                        <div class="aa-product-details-content">
                            <div class="row">
                                <!-- Modal view slider -->
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="aa-product-view-slider">
                                        <div id="demo-1" class="simpleLens-gallery-container">
                                            <div class="simpleLens-container">
                                                <div class="simpleLens-big-image-container">
                                                    <a data-lens-image="../Uploads/<?php echo htmlspecialchars($row_products['Image1']); ?>" class="simpleLens-lens-image"><img src="../Uploads/<?php echo htmlspecialchars($row_products['Image1']); ?>" class="simpleLens-big-image" width="250" height="300"></a>
                                                </div>
                                            </div>
                                            <div class="simpleLens-thumbnails-container">
                                                <a data-big-image="../Uploads/<?php echo htmlspecialchars($row_products['Image1']); ?>" data-lens-image="../Uploads/<?php echo htmlspecialchars($row_products['Image1']); ?>" class="simpleLens-thumbnail-wrapper" href="#">
                                                    <img src="../Uploads/<?php echo htmlspecialchars($row_products['Image1']); ?>" alt="" width="45" height="55">
                                                </a>
                                                <a data-big-image="../Uploads/<?php echo htmlspecialchars($row_products['Image2']); ?>" data-lens-image="../Uploads/<?php echo htmlspecialchars($row_products['Image2']); ?>" class="simpleLens-thumbnail-wrapper" href="#">
                                                    <img src="../Uploads/<?php echo htmlspecialchars($row_products['Image2']); ?>" alt="" width="45" height="55">
                                                </a>
                                                <a data-big-image="../Uploads/<?php echo htmlspecialchars($row_products['Image3']); ?>" data-lens-image="../Uploads/<?php echo htmlspecialchars($row_products['Image3']); ?>" class="simpleLens-thumbnail-wrapper" href="#">
                                                    <img src="../Uploads/<?php echo htmlspecialchars($row_products['Image3']); ?>" alt="" width="45" height="55">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal view content -->
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    <div class="aa-product-view-content">
                                      <form action="addCarts.php?productid=<?php echo $row_products['ID'] ?>" method="post">
                                        <h3><?php echo htmlspecialchars($row_products['Name']); ?></h3>
                                        <div class="aa-price-block">
                                            <span class="aa-product-view-price"><?php echo number_format($row_products['Price'], 0, ',', '.'); ?>đ</span>
                                            <p class="aa-product-avilability">Tình trạng: <span>Còn hàng</span></p>
                                        </div>
                                        <h4>Size</h4>
                                    
                                        <div class="aa-prod-view-size">
                                        
                                            <select name="sizes" id="sizes">
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                            </select>
                                        </div>
                                        <h4>Color</h4>
                                        <div class="aa-color-tag">
                                            <a href="#" class="aa-color-green"></a>
                                            <a href="#" class="aa-color-yellow"></a>
                                            <a href="#" class="aa-color-pink"></a>
                                            <a href="#" class="aa-color-black"></a>
                                            <a href="#" class="aa-color-white"></a>
                                        </div>
                                        <div class="aa-prod-quantity">
                                            
                                            <div class="flex text-[35px] items-center my-[10px]">
                                                <button type="button" id="decrease-button" class="inline-block  border-solid border border-[#e3e6ef] text-center leading-[20px] p-[4px] h-[40px] w-[35px] hover:bg-[#585252]">-</button>
                                                <input type="number" name="soluongmua" id="number-input" class="inline-block w-[60px] h-[40px] text-[20px] border-solid border border-[#e3e6ef] text-center leading-[30px] py-[1px] px-[2px]" style="width: 40px;" value="1" min="1">
                                                <button type="button" id="increase-button" class="hover:bg-[#585252] inline-block  border-solid border border-[#e3e6ef] text-center leading-[20px] p-[4px] h-[40px] ">+</button>
                                                <!-- xu ly + tang dan va - giam dan  -->
                                                <script>
                                                    var decreaseButton = document.getElementById("decrease-button");
                                                    var increaseButton = document.getElementById("increase-button");
                                                    var numberInput = document.getElementById("number-input");

                                                    decreaseButton.addEventListener("click", function() {
                                                        var currentValue = parseInt(numberInput.value);
                                                        var newValue = currentValue - 1;
                                                        numberInput.value = newValue;
                                                    });

                                                    increaseButton.addEventListener("click", function() {
                                                        var currentValue = parseInt(numberInput.value);
                                                        var newValue = currentValue + 1;
                                                        numberInput.value = newValue;
                                                    });
                                                </script>
                                            </div>
                                            
                                            <p class="aa-prod-category">
                                                Category: <a href="#"><?php echo htmlspecialchars($row_typeProduct['TypeName']); ?></a>
                                            </p>
                                        </div>
                                        <!-- Trường hidden để gửi thông tin sản phẩm -->
                                            <input type="hidden" name="productid" value="<?php echo $row_products['ID']; ?>">
                                            <input type="hidden" name="price" value="<?php echo $row_products['Price']; ?>">
                                            
                                        <div class="aa-prod-view-bottom">
                                            <button class="aa-add-to-cart-btn" type="submit">Thêm vào giỏ</button>
                                            <a class="aa-add-to-cart-btn" href="#">Ưa thích</a>
                                            <a class="aa-add-to-cart-btn" href="#">Mua Hàng</a>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aa-product-details-bottom">
                            <ul class="nav nav-tabs" id="myTab2">
                                <li><a href="#description" data-toggle="tab">Mô tả</a></li>
                                <li><a href="#review" data-toggle="tab">Đánh giá</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="description">
                                    <p>
                                    <?php echo htmlspecialchars($row_products['Description']); ?>
                                    </p>
                                   
                                </div>
                                <div class="tab-pane fade " id="review">
                                    <div class="aa-product-review-area">
                                        <h4>2 Đánh giá về <?php echo htmlspecialchars($row_products['Name']); ?></h4>
                                        <ul class="aa-review-nav">
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Nguyễn Thành Đat</strong> - <span>March 26, 2024</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Sản phẩm đẹp, chất liệu tốt, giống hình ảnh</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Nguyễn Duy Đạo</strong> - <span>March 15, 2024</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                        </div>
                                                        <p>Sản phẩm tốt</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <h4>Thêm nhận xét</h4>
                                        <div class="aa-your-rating">
                                            <p>Đánh giá của bạn</p>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                        </div>
                                        <!-- review form -->
                                        <form action="" class="aa-review-form">
                                            <div class="form-group">
                                                <label for="message">Nhận xét</label>
                                                <textarea class="form-control" rows="3" id="message"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Tên</label>
                                                <input type="text" class="form-control" id="name" placeholder="Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" placeholder="example@gmail.com">
                                            </div>

                                            <button type="submit" class="btn btn-default aa-review-submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Related product -->
                        <div class="aa-product-related-item">
                            <h3>Các sản phẩm liên quan</h3>
                            <ul class="aa-product-catg aa-related-item-slider">
                            <?php
                                while ($row_randomProducts = $result_randomProducts->fetch_assoc()) {
                            ?>
                                <!-- start single product item -->
                                <li>
                                   
                                   <figure>
                                       <a class="aa-product-img"  href="product-detail.php?id=<?php echo $row_randomProducts['ID']; ?>" >
                                       <img src="../Uploads/<?php echo htmlspecialchars($row_randomProducts['Image1']); ?>" alt="" width="250" height="300">
                                       </a>
                                       <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span> Add To Cart</a>
                                       <figcaption>
                                           <h4 class="aa-product-title"><a href="#"><?php echo htmlspecialchars($row_randomProducts['Name']); ?></a></h4>
                                           <span class="aa-product-price"><?php echo number_format($row_randomProducts['Price'], 0, ',', '.'); ?>đ</span>
                                           <span class="aa-product-price"><del>500.000<sup>đ</sup></del></span>
                                       </figcaption>
                                   </figure>                        
                                   <div class="aa-product-hvr-content">
                                       <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                       <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                       <a href="#" data-toggle="modal" data-target="#quick-view-modal" title="Quick View"><span class="fa fa-search"></span></a>
                                   </div>
                                   <span class="aa-badge aa-sale">SALE!</span>
                                   
                               </li>
                                <?php } ?>
                            </ul>
                            <!-- quick view modal -->
                            <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <div class="row">
                                                <!-- Modal view slider -->
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="aa-product-view-slider">
                                                        <div class="simpleLens-gallery-container" id="demo-1">
                                                            <div class="simpleLens-container">
                                                                <div class="simpleLens-big-image-container">
                                                                    <a class="simpleLens-lens-image" data-lens-image="img/view-slider/large/polo-shirt-1.png">
                                                                        <img src="img/view-slider/medium/polo-shirt-1.png" class="simpleLens-big-image">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="simpleLens-thumbnails-container">
                                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-1.png" data-big-image="img/view-slider/medium/polo-shirt-1.png">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-1.png">
                                                                </a>
                                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-3.png" data-big-image="img/view-slider/medium/polo-shirt-3.png">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                                                                </a>

                                                                <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-4.png" data-big-image="img/view-slider/medium/polo-shirt-4.png">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-4.png">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal view content -->
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="aa-product-view-content">
                                                        <h3>T-Shirt</h3>
                                                        <div class="aa-price-block">
                                                            <span class="aa-product-view-price">$34.99</span>
                                                            <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p>
                                                        <h4>Size</h4>
                                                        <div class="aa-prod-view-size">
                                                            <a href="#">S</a>
                                                            <a href="#">M</a>
                                                            <a href="#">L</a>
                                                            <a href="#">XL</a>  
                                                        </div>
                                                        <div class="aa-prod-quantity">
                                                            <form action="">
                                                                <select name="" id="">
                                                                <option value="0" selected="1">1</option>
                                                                <option value="1">2</option>
                                                                <option value="2">3</option>
                                                                <option value="3">4</option>
                                                                <option value="4">5</option>
                                                                <option value="5">6</option>
                                                                </select>
                                                            </form>
                                                            <p class="aa-prod-category">
                                                                Category: <a href="#">Polo T-Shirt</a>
                                                            </p>
                                                        </div>
                                                        <div class="aa-prod-view-bottom">
                                                            <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                            <a href="#" class="aa-add-to-cart-btn">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- / quick view modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / product category -->




    
    <?php
    include("pages/footer.php");

    ?>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn có chắc là muốn đăng xuất</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="admincp/login.php">Logout</a>
                </div>
            </div>
        </div>
    </div> 




    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
    <!-- SmartMenus jQuery plugin -->
    <script type="text/javascript" src="js/jquery.smartmenus.js"></script>
    <!-- SmartMenus jQuery Bootstrap Addon -->
    <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
    <!-- To Slider JS -->
    <script src="js/sequence.js"></script>
    <script src="js/sequence-theme.modern-slide-in.js"></script>
    <!-- Product view slider -->
    <script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
    <script type="text/javascript" src="js/jquery.simpleLens.js"></script>
    <!-- slick slider -->
    <script type="text/javascript" src="js/slick.js"></script>
    <!-- Price picker slider -->
    <script type="text/javascript" src="js/nouislider.js"></script>
    <!-- Custom js -->
    <script src="js/custom.js"></script>

</body>

</html>
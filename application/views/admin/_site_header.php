<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>政龍文教科技股份有限公司</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url("assets/css/bootstrap.css")?>" rel="stylesheet">

    <!-- Custom Google Web Font -->
    <link href="<?=base_url("assets/font-awesome/css/font-awesome.min.css")?>" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!-- Add custom CSS here -->
    <link href="<?=base_url("assets/css/landing-page.css")?>" rel="stylesheet">

    <script src="<?=base_url("assets/js/jquery-1.10.2.js")?>"></script>
</head>
<style>
    html, body {
        font-family: "Microsoft JhengHei", "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif
    }
    .container {
        width: 90% !important;
    }
    #func-goNext, #func-goPrevious
    {
        cursor: pointer;
    }
    .nav > li > a {
        padding: 0px;
    }
    .nav > li {
        padding: 15px 15px 15px 15px;
        line-height: 45px;
        font-size: 16px;
        font-family: "微軟正黑體";
    }
    /*.nav > li:hover {
        background-color: white;
    }*/
    .nav > li > a:hover {
        color: blue !important;
    }
</style>

<body>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=site_url("")?>"><img src="<?=site_url('')?>/assets/img/LOGO.bmp" alt="政龍文教" width="30" style="margin-top:-1px;">&nbsp;政龍文教</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?=site_url('/main/about')?>">關於政龍</a></li>
                    <li><a href="<?=site_url('/main/product')?>">產品介紹</a></li>
                    <li><a href="<?=site_url('/main/customer')?>">客戶登入</a></li>
                    <li><a>成功案例</li>
                    <!-- <li><a href="">解決方案</a></li> -->
                    <li><a>客戶專區</a></li>
                    <!-- <li><a href="">影音介紹</a></li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
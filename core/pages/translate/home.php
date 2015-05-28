<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>سامانه ترجمه انسانی برگردون</title>

        <script src="/medias/home/js/jquery-2.1.3.min.js"></script>
        <script src="/medias/home/js/bootstrap.min.js"></script>
        <script src="/medias/home/js/odometer.min.js"></script>
        <script src="/medias/home/js/owl.carousel.min.js"></script>

        <script src="/medias/home/js/bootstrap-datepicker.min.js"></script>
        <script src="/medias/home/js/bootstrap-datepicker.fa.min.js"></script>

        <link rel="stylesheet" type="text/css" href="/medias/home/css/bootstrap.min.css">
        <link rel="stylesheet" href="/medias/home/css/odometer-theme-minimal.css" />
        <link rel="stylesheet" href="/medias/home/css/owl.carousel.min.css" />
        <link rel="stylesheet" href="/medias/home/css/owl.theme.default.min.css" />
        <link rel="stylesheet" type="text/css" href="/medias/home/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="/medias/home/css/font-awesome.min.css">
        <style type="text/css">
            .customer .col-md-6:first-child {
                border-right: 1px solid #DDD;
            }
        </style>

        <link href='http://www.fontonline.ir/css/BNazanin.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/medias/home/css/style.css" />
        <script>
//            odometerOptions = {auto: true}; // Disables auto-initialization

            // For each odometer, initialize with the theme passed in:
//            var odometer = new Odometer({el: $('.odometer')[0], value: 123, theme: 'car'});
//            odometer.render();
        </script>
    </head>
    <body>
        <header class="navbar-container">
            <nav class="navbar navbar-default center-block">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header pull-left">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="navbar-header pull-right">
                        <a class="navbar-brand" href="#">
                            <img alt="Brand" src="/medias/home/images/logo.png" width="55" height="55">
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right navbar-links">
                            <li><a href="#">راهکارها</a></li>
                            <li><a href="#">معرفی</a></li>
                            <li><a href="#">همکاران</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-links">
                            <li class="contactus"><a href="#"><button class="btn btn-outline order">تماس</button></a></li>
                            <li class="signin"><a href="/panel"><button class="btn btn-outline sign">ورود</button></a></li>
                        </ul>
                    </div><!-- .navbar-collapse -->
                </div><!-- .container-fluid -->
            </nav><!-- .navbar -->
        </header><!-- .navbar-container -->

        <div class="main-container">
            <section class="main">
                <form action="/submit-project" method="post">
                    <div class="main-content row center-block">
                        <div class="col-xs-3">
                            <div class="trans-title first-child">
                                <div class="number check-icon green-bg"><i class="fa fa-check"></i></div>
                                <h3 class="text-center green">ثبت سفارش</h3>
                            </div>

                            <div class="trans-body">
                                <p class="text-center clock-remain"><i class="fa fa-calendar"></i></p>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="datepicker" placeholder="تاریخ">
                                </div>
                                <button class="btn btn-block btn-lg btn-info margin-top-20">ترجمه</button>
                            </div>
                        </div>

                        <div class="col-xs-3">
                            <div class="trans-title">
                                <div class="number-com">3</div>
                                <h3 class="text-center">تخصص</h3>
                            </div>

                            <div class="trans-body">
                                <div class="checkbox expert">
                                    <label>
                                        <input type="checkbox" value="">
                                        پزشکی
                                    </label>
                                    <br/>
                                    <label>
                                        <input type="checkbox" value="">
                                        روانشناسی
                                    </label>
                                    <br/>
                                    <label>
                                        <input type="checkbox" value="">
                                        زیست
                                    </label>
                                    <br/>
                                    <label>
                                        <input type="checkbox" value="">
                                        کامپیوتر
                                    </label>
                                    <br/>
                                    <label>
                                        <input type="checkbox" value="">
                                        حقوق
                                    </label>				  
                                </div>
                                <hr />
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="">
                                        سایر موارد
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="trans-title">
                                <div class="number-com">2</div>
                                <h3 class="text-center">بارگذاری</h3>
                            </div>
                            <div class="trans-body">
                                <form action="#">
                                    <span class="btn btn-default btn-block btn-file margin-top-20">
                                        <i class="fa fa-cloud-upload"></i> آپلود <input type="file">
                                    </span>
                                    <p class="files-to-upload"></p>
                                </form>
                                <p>فرمت های پشتیبانی:</p>
                                <a href="#"><i class="fa fa-file-word-o"></i> <i class="fa fa-file-pdf-o"></i> <i class="fa fa-file-excel-o"></i> <i class="fa fa-file-powerpoint-o"></i> <i class="fa fa-file-text-o"></i> لیست همه</a>
                                <hr />
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-default btn-block text4tran" data-toggle="modal" data-target="#myModal">
                                    ارسال متن
                                </button>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="trans-title .last-child">
                                <div class="number-end">1</div>
                                <h3 class="text-center">انتخاب زبان</h3>
                            </div>

                            <div class="trans-body">
                                <p>از:</p>
                                <select class="form-control">
                                    <option>فارسی</option>
                                    <option selected>انگلیسی</option>
                                    <option>عربی</option>
                                </select>

                                <p class="text-center to-flash"><i class="fa fa-arrow-down"></i></p>

                                <p>به:</p>
                                <select class="form-control">
                                    <option selected>فارسی</option>
                                    <option>انگلیسی</option>
                                    <option>عربی</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

            <section class="data">
                <div class="data-content center-block text-center">
                    <span class="odometer-container">
<!--                        <span class="odometer">00000</span>
                        <span>کلمات ترجمه شده</span>-->
                    </span>
                    <div class="clear" style="clear: both"></div>
                </div>
            </section>

            <section class="customer">
                <style>
                    .customer h3{
                        color: red;
                    }
                    .customer img{
                        width: 100px;
                        height: 100px;
                    }
                    .customer{
                        line-height: 20pt;
                    }
                </style>
                <section class="customer-content center-block">
                    <div class="col-md-6">
                        <img src="/medias/home/images/customer1.png"/>
                        <h3>
                            پول کافی ندارید؟
                        </h3>                         

                        نگران نباشید! اساس شکل گیری برگردوون حل این
                        مشکل است! 

                        فایل خود را به صورت رایگان
                        آپلود کرده و منتظر صدها پیشنهاد باشید مطمئن باشید قیمت مناسب پیدا می‌کنید! 
                    </div>

                    <div class="col-md-6">
                        <img src="/medias/home/images/customer4.png"/>
                        <h3>
                            زمان کمی برایتان مانده ؟؟
                        </h3>
                        باز هم نگران نباشید!
                        فایل خود را به صورت رایگان آپلود کرده و زمان تحویل را مشخص کنید و منتظر پیشنهادات باشید زمانها را با هم مقایسه کرده و پیشنهاد مناسب را انتخاب کنید!  
                        <br/><br/>
                    </div>
                    <div class="col-md-6">
                        <img src="/medias/home/images/customer3.png"/>
                        <h3>
                            هنوز نگرانید؟ 
                        </h3>
                        باز هم نگران نباشید! 
                        برگردوون ضامن امنیت مالی و کیفی کار شماست تا زمانی که کار مترجم را تایید نکنید پول شما محفوظ میماند! در صورت وجود هر گونه مشکلی میتواند با ارسال تیکت پروژه را به کمیسیون داروی ارجاع دهید.
                        پس با خیال راحت فایل خود را به صورت رایگان آپلود کنید و منتظر پیشنهادات شگفت انگیز باشید!  
                        <br/><br/>
                    </div>
                    <div class="col-md-6">
                        <img src="/medias/home/images/customer2.png"/>
                        <h3>
                            کیفیت کار برایتان حیاتی است؟
                        </h3>
                        برگردوون پاتوق بهترین هاست!  
                        فایل خود را به صورت رایگان آپلود کرده و منتظر پیشنهادات باشید  در هنگام بررسی پیشنهاد ها مترجمان توصیه شده را در نظر بگیرید و با خیال راحت انتخاب کنید 
                        در طول کار میتوانید به راحتی تمامی نکات رو از طریق پیامک یا چت داخلی به مترجم منتقل کنید 

                    </div>

                    <div class="clear" style="clear: both"></div>
                </section>
            </section>
            <!--
                    <section class="customer">
                            <section class="customer-content center-block">
                                    <header class="customer-title">
                                            <h1 class="text-center">برگردون به خیلی ها کمک کرده:</h1>
                                    </header>
                                            <div class="owl-carousel">
                                                <div class="item"><h4>1</h4></div>
                                                <div class="item"><h4>2</h4></div>
                                                <div class="item"><h4>3</h4></div>
                                                <div class="item"><h4>4</h4></div>
                                                <div class="item"><h4>5</h4></div>
                                                <div class="item"><h4>6</h4></div>
                                                <div class="item"><h4>7</h4></div>
                                                <div class="item"><h4>8</h4></div>
                                                <div class="item"><h4>9</h4></div>
                                                <div class="item"><h4>10</h4></div>
                                                <div class="item"><h4>11</h4></div>
                                                <div class="item"><h4>12</h4></div>
                                            </div>
                            </section>
                    </section> -->

<!--            <section class="ourteam">
                <div class="row ourteam-content center-block">
                    <header class="ourteam-title">
                        <h1 class="text-center">به جامعه مترجمین ما بپیوندید!</h1>
                    </header>
                    <div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="row">
                                <div class="col-xs-6">
                                    <figure>
                                        <img src="/medias/home/images/p1.jpg" class="img-responsive img-rounded" width="243" />
                                        <figcaption class="text-right"><b>مترجم</b><br />از ایران</figcaption>
                                    </figure>
                                </div>

                                <div class="col-xs-6">
                                    <figure>
                                        <img src="/medias/home/images/p2.jpg" class="img-responsive img-rounded" width="243" />
                                        <figcaption class="text-right"><b>مترجم</b><br />از ایران</figcaption>
                                    </figure>
                                </div>		
                            </div>

                            <div class="team-description">
                                <div class="arrow"></div>
                                <p>با برگردون من تونستم شغل بهتری پیدا کنم و تنها از خانه کار کنم که این باعث شد من مدت زمان بیشتری را با دخترم باشم.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <figure>
                            <img src="/medias/home/images/p3.jpg" class="img-responsive img-rounded" width="510" />
                            <figcaption class="text-right"><b>مترجم</b><br />از ایران</figcaption>
                        </figure>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 joinus">
                            <a class="text-center" href="#"><button type="button" class="btn btn-block btn-light-blue become-translator">مترجم شوید</button></a>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </div>
            </section>-->

            <footer class="footer">
                <section class="footer-content center-block">
                    <div class="contact-sale">
                        <h2 class="text-center">پروژه های با حجم بالا</h2>
                        <p class="text-center">با برگردون خدمات و محصولات خود را جهانی کنید.</p>
                        <a class="contactus-footer" href="#"><button type="button" class="btn btn-green-footer">ارتباط با مسوول فروش</button></a>
                    </div>

                    <div class="footer-links text-center">
                        <nav class="navbar-footer">
                            <a href="#">راهنما</a>
                            <a href="#">همکاران</a>
                            <a href="#">مترجمین</a>
                            <a href="#">پشتیبانی</a>
                            <a href="#">وبلاگ</a>
                            <a href="#">درباره ما</a>
                        </nav>
                    </div>

                    <div class="social">
                        <a class="facebook" href="#" title="on Facebook"></a>
                        <a class="twitter" href="#" title="on Twitter"></a>
                        <a class="googleplus" href="#" title="on Google+"></a>
                        <a class="linkedin" href="#" title="on LinkedIn"></a>
                    </div>
                </section>
            </footer>
        </div><!-- .main-container -->
        <script>
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            })
//            $(document).ready(function () {
//                setTimeout(function () {
//                    $('.odometer').html(523657);
//                }, 1000);
//            });

            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                        numFiles = input.get(0).files ? input.get(0).files.length : 1,
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
                $('.files-to-upload').html(numFiles + ' فایل آماده آپلود است.');
                $('.files-to-upload').addClass('alert alert-info margin-20');
            });

            $('#datepicker').datepicker();

            $('.icon-circle-arrow-left').addClass('fa fa-arrow-circle-left');
            $('.icon-circle-arrow-right').addClass('fa fa-arrow-circle-right')


        </script>

        <!--Start of Zopim Live Chat Script-->
        <script type="text/javascript">
            window.$zopim || (function (d, s) {
                var z = $zopim = function (c) {
                    z._.push(c)
                }, $ = z.s =
                        d.createElement(s), e = d.getElementsByTagName(s)[0];
                z.set = function (o) {
                    z.set.
                            _.push(o)
                };
                z._ = [];
                z.set._ = [];
                $.async = !0;
                $.setAttribute('charset', 'utf-8');
                $.src = '//v2.zopim.com/?2xXrZepVMUi649nQbDeWvoDO6zyai053';
                z.t = +new Date;
                $.
                        type = 'text/javascript';
                e.parentNode.insertBefore($, e)
            })(document, 'script');
        </script>
        <!--End of Zopim Live Chat Script-->
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close pull-left" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#">
                            <textarea class="form-control" rows="3"></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
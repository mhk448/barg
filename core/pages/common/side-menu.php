<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: May 13, 2013 , 6:27:47 PM
 * mhkInfo:
 */
/* @var $user User */
//$user->usergroup="User";
//if($user->usergroup=="Guest" ) 
//    return;
?>



<!-- right side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-right info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!--        <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
                        <span class="input-group-btn">
                            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <!--<li class="header">MAIN NAVIGATION</li>-->
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>پنل کاربری</span> <i class="fa fa-angle-right pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
            </li>

            <?// if ($user->isAgency()) { ?>
                <li class="active treeview">
                    <a class=""><i class="fa fa-envelope"></i>
                        لیست پروژه ها</a>
                    <ul class="treeview-menu">
                        <li><a class="side-ajax" href="projects_run_<?php echo $user->id ?>" >پروژه های در حال اجرا</a></li>
                        <li><a class="side-ajax" href="projects_finish_<?php echo $user->id ?>" >پروژه های تمام شده</a></li>
                        <li><a class="side-ajax2" href="projects_open_<?php echo $user->id ?>" >پروژه های باز</a></li>
                    </ul>
                </li>
            <?// } ?>

            <li>
                <a href="pages/mailbox/mailbox.html">
                    <i class="fa fa-envelope"></i> <span>Mailbox</span>
                    <small class="label pull-left bg-yellow">12</small>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

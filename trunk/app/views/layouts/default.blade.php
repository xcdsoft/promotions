<!DOCTYPE html>
<html lang="en" ng-app="xcdapp">

<head>
    <title>XCDSENDY</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <% HTML::style('css/bootstrap.min.css')%>
    <% HTML::style('css/bootstrap-responsive.min.css')%>
    <% HTML::style('css/fullcalendar.css')%>
    <% HTML::style('css/maruti-style.css')%>
    <% HTML::style('css/maruti-media.css')%>
    <% HTML::style('css/uniform.css')%>
    <% HTML::style('css/select2.css')%>
    <% HTML::style('css/datepicker.css')%>
</head>
<body>

<!--Header-part-->
<div id="header">
    <h1><a href="#">XCDSENDY</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-messaages-->
<div class="btn-group rightzero"><a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a> <a
        class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a> <a
        class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span
        class="label label-important">5</span></a> <a class="top_message tip-bottom" title="Manage Orders"><i
        class="icon-shopping-cart"></i></a></div>
<!--close-top-Header-messaages-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li class=""><a title="" href="#"><i class="icon icon-user"></i> <span class="text">Profile</span></a></li>
        <li class=" dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages"
                                                    class="dropdown-toggle"><i class="icon icon-envelope"></i> <span
                class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#">new message</a></li>
                <li><a class="sInbox" title="" href="#">inbox</a></li>
                <li><a class="sOutbox" title="" href="#">outbox</a></li>
                <li><a class="sTrash" title="" href="#">trash</a></li>
            </ul>
        </li>
        <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
        <li class=""><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a>
        </li>
    </ul>
</div>
<div id="search">
    <input type="text" placeholder="Search here..."/>
    <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        <li class="active"><a href="index.html"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
        <li><a href="charts.html"><i class="icon icon-signal"></i> <span>Charts &amp; graphs</span></a></li>
        <li><a href="widgets.html"><i class="icon icon-inbox"></i> <span>Widgets</span></a></li>
        <li><a href="tables.html"><i class="icon icon-th"></i> <span>Tables</span></a></li>
        <li><a href="grid.html"><i class="icon icon-fullscreen"></i> <span>Full width</span></a></li>
        <li class="submenu"><a href="#"><i class="icon icon-th-list"></i> <span>Forms</span> <span
                class="label">3</span></a>
            <ul>
                <li><a href="form-common.html">Basic Form</a></li>
                <li><a href="form-validation.html">Form with Validation</a></li>
                <li><a href="form-wizard.html">Form with Wizard</a></li>
            </ul>
        </li>
        <li><a href="buttons.html"><i class="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
        <li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Eelements</span></a></li>

        <li class="submenu"><a href="#"><i class="icon icon-file"></i> <span>Addons</span> <span class="label">3</span></a>
            <ul>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="calendar.html">Calendar</a></li>
                <li><a href="chat.html">Chat option</a></li>
            </ul>
        </li>

    </ul>
</div>

<div id="content">
    <div id="content-header">
        @yield('breadcrumb')
        @yield('titleBlock')
    </div>

    @yield('dashboard')
<!--        <div class="quick-actions_homepage">-->
<!--        <ul class="quick-actions">-->
<!--            <li><a href="#"> <i class="icon-dashboard"></i> My Dashboard </a></li>-->
<!--            <li><a href="#"> <i class="icon-shopping-bag"></i> Shopping Cart</a></li>-->
<!--            <li><a href="#"> <i class="icon-web"></i> Web Marketing </a></li>-->
<!--            <li><a href="#"> <i class="icon-people"></i> Manage Users </a></li>-->
<!--            <li><a href="#"> <i class="icon-calendar"></i> Manage Events </a></li>-->
<!--        </ul>-->
<!--    </div>-->

    <div class="container-fluid">
        @yield('content')
    </div>
</div>
<div class="row-fluid">
    <div id="footer" class="span12"> 2014 &copy;XCDSENDY . Developed and design by <a href="http://xcdsoft.com">XCDSOFT</a>
    </div>
</div>
<% HTML::script("js/excanvas.min.js")%>
<% HTML::script("js/jquery.min.js")%>
<% HTML::script("js/angular.min.js")%>
<% HTML::script("js/controllers/campaign/create.js")%>
<% HTML::script("js/jquery.ui.custom.js")%>
<% HTML::script("js/bootstrap.min.js")%>
<% HTML::script("js/jquery.peity.min.js")%>
<% HTML::script("js/fullcalendar.min.js")%>
<% HTML::script("js/bootstrap-datepicker.js")%>
<% HTML::script("js/bootstrap-colorpicker.js")%>
<% HTML::script("js/fullcalendar.min.js")%>
<% HTML::script("js/maruti.js")%>
<% HTML::script("js/maruti.chat.js")%>
<% HTML::script("js/jquery.uniform.js")%>
<% HTML::script("js/select2.min.js")%>
<% HTML::script("js/jquery.validate.js")%>
<% HTML::script("js/maruti.form_validation.js")%>
<% HTML::script("js/maruti.form_common.js")%>

<script type="text/javascript">
    // This function is called from the pop-up menus to transfer to
    // a different page. Ignore if the value returned is a null string:
    function goPage(newURL) {

        // if url is empty, skip the menu dividers and reset the menu selection to default
        if (newURL != "") {

            // if url is "-", it is this page -- reset the menu:
            if (newURL == "-") {
                resetMenu();
            }
            // else, send page to designated URL
            else {
                document.location.href = newURL;
            }
        }
    }

    // resets the menu selection upon entry to this page:
    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>
</body>

</html>

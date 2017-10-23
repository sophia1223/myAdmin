<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}" id="csrf_token">
    <meta name="route" content="{{ $route }}" id="route">
    <title>后台管理</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <!-- datatable -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/datatables/datatables.min.css') }}">
    <!-- select2 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}">
    <!-- parsley -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/parsley/parsley.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/AdminLTE.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/gritter/css/jquery.gritter.css') }}">
    <!--fontIconPicker-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/fontIconPicker/css/jquery.fonticonpicker.css') }}">
    <link rel="stylesheet"
          href="{{ URL::asset('assets/plugins/fontIconPicker/themes/bootstrap-theme/jquery.fonticonpicker.bootstrap.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
    <!--zTree-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/zTree/theme/metroStyle/metroStyle.css') }}">
    <!--jqueryUI-datetimepicker-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jQueryUI/css/jquery-ui.css') }}">
    <!--main-->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
    <!--switchery-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/switchery/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('js/plugins/switchery/switchery.min.css') }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="javascript:" class="logo">
            <span class="logo-mini"><b>A</b>LT</span>
            <span class="logo-lg"><b>My</b>Admin</span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="javascript:" class="sidebar-toggle" data-toggle="push-menu">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!--用户账号-->
                    <li class="dropdown user user-menu">
                        <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ URL::asset('assets/img/user2-160x160.jpg') }}" class="user-image"
                                 alt="User Image">
                            <span class="hidden-xs">{{ $user->realname }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ URL::asset('assets/img/user2-160x160.jpg') }}" class="img-circle"
                                     alt="User Image">
                                <p>
                                    {{ $user->realname }} - {{ $user->roles[0]->name }}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="javascript:" id="showChangePwd" class="btn btn-default btn-flat">修改密码</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">退出登录</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!--左侧面板-->
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ URL::asset('assets/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ $user->realname }}</p>
                    <a href="javascript:"><i class="fa fa-circle text-success"></i> {{ $user->roles[0]->name }}</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" class="sidebar-form">
                <div class="input-group">
                    <input name="q" class="form-control" placeholder="搜索...">
                    <span class="input-group-btn">
                <button name="search" id="search-btn" class="btn btn-flat">
                    <i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!--左侧菜单-->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">菜单</li>
                <li>
                    <a href="javascript:" uri="admin/index" class="page_jump">
                        <i class="fa fa-dashboard"></i>
                        <span>首页</span>
                    </a>
                </li>
                @foreach ($menus as $row)
                    @if (empty($row['sub']))
                        <li @if($route == substr($row['route'],6)) class="active" @endif>
                            <a href="javascript:" uri="{{ $row['route'] }}" class="page_jump">
                                <i class="{{ $row['icon'] }}"></i>
                                <span>{{ $row['name'] }}</span>
                            </a>
                        </li>
                    @else
                        <li class="treeview">
                            <a href="javascript:">
                                <i class="{{ $row['icon'] }}"></i> <span>{{ $row['name'] }}</span>
                                <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($row['sub'] as $item)
                                    <li @if($route == substr($item['route'],6)) class="active" @endif><a href="javascript:" uri="{{ $item['route'] }}" class="page_jump"><i
                                                    class="{{ $item['icon'] }}"></i> {{ $item['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    </aside>
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        @yield('content')
        <section class="content clearfix" id="content">
        </section>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2017 Sophia </strong> 版权所有
    </footer>
</div>
<!--script-->
<!-- jQuery 3 -->
<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.cookie.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/adminlte.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/gritter/js/jquery.gritter.js') }}"></script>
<!-- dataTable -->
<script src="{{ URL::asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<!-- select2 -->
<script src="{{ URL::asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/page.js') }}"></script>
<script src="{{ URL::asset('js/admin/admin.crud.js') }}"></script>
<script src="{{ URL::asset('js/admin/dashboard.js') }}"></script>
<!-- parsley -->
<script src="{{ URL::asset('assets/plugins/parsley/parsley.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/parsley/i18n/zh_cn.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/parsley/i18n/zh_cn.extra.js') }}"></script>
<!--fontIconPicker-->
<script src="{{ URL::asset('assets/plugins/fontIconPicker/js/jquery.fonticonpicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fontIconPicker/js/fa-icon-source.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
<!-- echarts -->
<script src="{{ URL::asset('assets/plugins/echarts/echarts.common.min.js') }}"></script>
<!--UEditor-->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/UEditor/ueditor.config.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/UEditor/ueditor.all.js') }}"></script>
<!-- dateTimePicker -->
<script src="{{ URL::asset('assets/plugins/bootstrap-dateTimePicker/js/moment-with-locales.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-dateTimePicker/js/bootstrap-datetimepicker.js') }}"></script>
<!--zTree-->
<script src="{{ URL::asset('assets/plugins/zTree/js/jquery.ztree.core.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/zTree/js/jquery.ztree.excheck.js') }}"></script>
<!--jquery-ui datetimepicker-->
<script src="{{ URL::asset('assets/plugins/jQueryUI/js/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jQueryUI/js/jquery-ui-timepicker-addon.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jQueryUI/js/datepicker-zh-CN.js') }}"></script>
<!--switchery-->
<script src="{{ URL::asset('assets/plugins/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('js/switcher.init.js') }}"></script>
<script src="{{ asset('js/plugins/switchery/switchery.min.js') }}"></script>

@include('admin.dashboard.updatePassword')

</body>
</html>

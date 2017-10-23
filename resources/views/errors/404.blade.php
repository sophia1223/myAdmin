<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <!--main-->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
</head>
<body>
<div class="errorBox">
    <div class="errorBoxPage">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="errorBoxContent">
            <h3><i class="fa fa-warning text-yellow"></i> 页面未找到</h3>
            <p>
                抱歉！页面好像去火星了~
                您可以<a href="{{ url('admin/index') }}">返回首页</a>。
            </p>
        </div>
    </div>
</div>
</body>
</html>
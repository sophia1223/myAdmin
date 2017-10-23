<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403</title>
    <!--main-->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
</head>
<body>
<div class="errorBox">
    <div class="errorPage">
        <h2 class="headline text-yellow"> 403</h2>
        <div class="errorContent">
            <h3><i class="fa fa-warning text-yellow"></i> 禁止访问</h3>
            <p>
                服务器拒绝了您的浏览请求。
                您可以<a href="{{ url('admin/index') }}">返回首页</a>。
            </p>
        </div>
    </div>
</div>
</body>
</html>

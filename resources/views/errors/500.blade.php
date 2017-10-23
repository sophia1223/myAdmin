<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>500</title>
    <!--main-->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
</head>
<body>
<div class="errorBox">
    <div class="errorBoxPage">
        <h2 class="headline text-red"> 500</h2>
        <div class="errorBoxContent">
            <h3><i class="fa fa-warning text-red"></i> 服务器内部错误</h3>
            <p>
                服务器开小差了。您可以<a href="{{ url('admin/index') }}">返回首页</a>。
            </p>
        </div>
    </div>
</div>
</body>
</html>
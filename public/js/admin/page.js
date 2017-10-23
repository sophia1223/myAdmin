var oPage = { title: '', url: location.href };
var page = {
    success: 'confirm.png',
    failure: 'error.png',
    inform: function(title, text, image) {
        $.gritter.add({title: title, text: text, image: page.imgRoot() + image});
    },
    siteRoot: function() {
        var path = window.location.pathname;
        var paths = path.split('/');
        if (paths[2] === 'public'){
            return '/' + paths[1] + '/' + paths[2] + '/admin/';
        }
        return '/admin/';

    },
    publicRoot: function() {
        var path = window.location.pathname;
        var paths = path.split('/');
        if (paths[2] === 'public'){
            return '/' + paths[1] + '/' + paths[2] + '/';
        }
        return '/';
    },
    imgRoot: function() {
        var path = window.location.pathname;
        var paths = path.split('/');
        if (paths[2] === 'public'){
            return '/' + paths[1] + '/' + paths[2] + '/img/';
        }
        return '/img/';
    },
    ajaxLoader: function() {
        return "<img id='ajaxLoader' alt='' src='" + page.imgRoot() + "throbber.gif' " +
        "style='vertical-align: middle;'/>"
    },
    getTabContent: function(url) {
        $('#content').html(page.ajaxLoader);
        $.ajax({
            type: 'GET',
            url: page.siteRoot() + url,
            success: function(result) {
                if(result.statusCode === 500){
                    page.inform('权限不足', '没有此功能权限', page.failure);
                    window.location.reload();
                }else if (result.statusCode === 401){
                    page.inform(result.message, '请重新登录', page.failure);
                    window.location.href= page.siteRoot() + 'login';
                }
                else {
                    $('#content').html(result);
                    oPage.url = page.siteRoot() + url;
                    history.pushState(oPage, oPage.title, oPage.url);
                }
            },
            error: function(e) {
                var obj = JSON.parse(e.responseText);
                page.inform('出现异常', obj['message'], page.failure);
            }
        });
    },
    getTabContentHistory: function(url) {
        $('#content').html(page.ajaxLoader);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(result) {
                if(result.statusCode === 500){
                    page.inform('权限不足', '没有此功能权限', page.failure);
                    window.location.reload();
                }else if (result.statusCode === 401){
                    page.inform(result.message, '请重新登录', page.failure);
                    window.location.href= page.siteRoot() + 'login';
                }
                else {
                    $('#content').html(result);
                }
            },
            error: function(e) {
                var obj = JSON.parse(e.responseText);
                page.inform('出现异常', obj['message'], page.failure);
            }
        });
    },

    MenusActive: function() {
        $('.treeview').removeClass('active menu-open');
        $('.sidebar-menu li .active').parents('.treeview').addClass('active');
    }
};
window.onpopstate = function(e) {
    oPage.url = e.state.url;
    page.getTabContentHistory(oPage.url);

    //菜单选中替换
    var $uri = 'admin/' + oPage.url.split(page.siteRoot())[1];
    $('.sidebar-menu').find('li').removeClass('active');
    $(".sidebar-menu a[uri='"+ $uri +"']").parent().addClass('active');
    page.MenusActive();
};
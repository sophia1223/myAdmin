var pageUrl = $('#route').attr('content');
$(function(){
    page.MenusActive();
    page.getTabContent(pageUrl);
    $('.page_jump').click(function () {
        //菜单选中
        $('.sidebar-menu').find('li').removeClass('active');
        $(this).parent().addClass('active');
        page.MenusActive();

        //加载内容
        url = $(this).attr('uri').substr(6);
        page.getTabContent(url);
    });

    $("#showChangePwd").click(function () {
        $("#updatePassword").modal('show');
    });

});
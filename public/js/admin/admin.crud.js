var crud = {
    unbindEvents: function () {
        $('#add-record').unbind('click');
        $(document).off('click', '.fa-edit');
        $(document).off('click', '.fa-eye');
        $(document).off('click', '.act-approval');
        $(document).off('click', '.act-attend');
        $(document).off('click', '.act-show');
        $('#confirm-delete').unbind('click');
    },
    initDataTable: function (table, columnDefs, order, start) {
        $('#data-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: page.siteRoot() + table + '/index',
            bSortable: false,
            order: [[start, order]],
            stateSave: true,
            autoWidth: false,
            scrollX: true,
            columnDefs: columnDefs,
            language: {
                searchPlaceholder: "searchPlaceholder",
                url: page.publicRoot() + 'files/ch.json'
            },
            lengthMenu: [[15, 25, 50, -1], [15, 25, 50, '所有']],
            buttons: []
        });

    },
    ajaxRequest: function (requestType, ajaxUrl, data, obj) {
        if (data) {
            data.append('_token', $('#csrf_token').attr('content'));
        }
        $.ajax({
            type: requestType,
            dataType: 'json',
            url: ajaxUrl,
            data: data,
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.statusCode === 200) {
                    switch (requestType) {
                        case 'DELETE':
                            $('#data-table').dataTable().fnDestroy();
                            crud.initDataTable(obj);
                            break;
                        default:
                            break;
                    }
                }
                page.inform(
                    '操作结果', result.message,
                    result.statusCode === 200 ? page.success : page.failure
                );
                return false;
            },
            error: function (e) {
                var obj = JSON.parse(e.responseText);
                var errors = obj['errors'];
                for (var x in errors) {
                    page.inform('出现异常', errors[x], page.failure);
                }
            }

        });
    },
    init: function (homeUrl, formId, ajaxUrl, requestType) {
        // Select2
        $('.select2').select2();

        // Cancel button
        $('#cancel, #record-list').on('click', function () {
            page.getTabContent(homeUrl);
        });

        // Parsley
        var $form = $('#' + formId);
        crud.formParsley($form, requestType, ajaxUrl);
    },
    index: function (table) {
        crud.unbindEvents();
        //默认对齐方式
        var columnDefs = [{targets: [$('#data-table').find('thead tr th').length - 1], className: 'text-right'}];
        columnDefs = arguments[1] ? columnDefs.concat(arguments[1]) : columnDefs;
        //默认datatable参数
        var order = arguments[2] ? arguments[2] : 'desc';
        //默认排序列数
        var start = arguments[3] ? arguments[3] : 0;

        // 显示记录列表
        crud.initDataTable(table, columnDefs, order, start);

        // 新增记录
        $('#add-record').click(function () {
            page.getTabContent(table + '/create');
        });

        // 编辑记录
        $(document).on('click', '.fa-edit', function () {
            var url = $(this).parents().eq(0).attr('id');
            url = url.replace('_', '/');
            page.getTabContent(table + '/' + url);
        });

        // 查看记录
        $(document).on('click', '.fa-eye', function () {
            var url = $(this).parents().eq(0).attr('id');
            url = url.replace('_', '/');
            page.getTabContent(table + '/' + url);
        });

        // 删除记录
        var id/*, $row*/;
        $(document).on('click', '.fa-trash', function () {
            id = $(this).parents().eq(0).attr('id');
            $('#modal-dialog').modal({backdrop: true});
        });
        $('#confirm-delete').on('click', function () {
            crud.ajaxRequest(
                'DELETE', page.siteRoot() + table + '/destroy/' + id + '?_token=' + $('#csrf_token').attr('content'),
                false, table
            );
        });

    },
    create: function (formId, table) {
        this.init(table + '/index', formId, table + '/store', 'POST');
    },
    edit: function (formId, table) {
        var id = $('#id').val();
        this.init(table + '/index', formId, table + '/update/' + id, 'POST');
    },
    approval: function (formId, table) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            new Switchery(html);
        });
        var id = $('#id').val();
        this.init(table + '/index', formId, table + '/approval/' + id, 'POST');
    },
    formParsley: function ($form, requestType, ajaxUrl) {

        if ($('#container').length > 0) {
            crud.kedit('textarea[name="content"]');
        }
        $form.parsley().on('form:validated', function () {
            if ($('.parsley-error').length === 0) {
                var data = new FormData($form[0]);
                //请求
                crud.ajaxRequest(requestType, page.siteRoot() + ajaxUrl, data);
            }
        }).on('form:submit', function () {
            return false;
        });
    },

    kedit: function (kedit) {
        KindEditor.create(kedit, {
            width: '100%',
            height: '400px',
            resizeMode: 0,
            allowPreviewEmoticons: true,
            langType: 'zh-CN',
            allowFileManager: true,
            items: [
                'copy', 'plainpaste', 'wordpaste', 'selectall', 'justifyleft', 'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'superscript', 'title', 'fontname',  'fontsize', 'bgcolor', 'bold', 'underline', 'image', '|'
            ]
        });
    }
};

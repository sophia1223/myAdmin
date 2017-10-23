<div class="box box-primary">
    <div class="box-header">
        @include('admin.partials.list_header',['table' => 'menus'])
    </div>
    <div class="box-body">
        <table id="data-table" class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>#</th>
                <th>菜单名称</th>
                <th>父级菜单</th>
                <th>功能</th>
                <th>排序</th>
                <th>创建时间</th>
                <th>更新时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
        </table>
    </div>
</div>
@include('admin.partials.modal_dialog')

<script>
$(crud.index('menus', 'asc', 4));
</script>

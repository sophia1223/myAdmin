<div class="box box-primary">
    <div class="box-header">
        @include('admin.partials.list_header',['table' => 'admins'])
    </div>
    <div class="box-body">
        <table id="data-table" class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>#</th>
                <th>管理员账号</th>
                <th>真实姓名</th>
                <th>创建时间</th>
                <th>更新时间</th>
                <th>状态</th>
            </tr>
            </thead>
            <tbody>
        </table>
    </div>
</div>
@include('admin.partials.modal_dialog')

<script>
    $(crud.index('admins'));
</script>

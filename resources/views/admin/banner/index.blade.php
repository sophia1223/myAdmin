<div class="box box-primary banner">
    <div class="box-header">
        @include('admin.partials.list_header',['table' => 'banners'])
    </div>
    <div class="box-body">
        <table id="data-table" class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>#</th>
                <th>图片</th>
                <th>备注</th>
                <th>位置</th>
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
$(crud.index('banners'));
</script>

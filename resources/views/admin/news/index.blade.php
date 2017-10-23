<div class="box box-primary">
    <div class="box-header">
        @include('admin.partials.list_header',['table' => 'news'])
    </div>
    <div class="box-body">
        <table id="data-table" class="display nowrap table table-striped table-bordered table-hover table-condensed">
            <thead>
            <tr>
                <th>#</th>
                <th>标题</th>
                <th>新闻类型</th>
                <th>发布人</th>
                <th>状态</th>
                <th>点击量</th>
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
$(crud.index('news'));
</script>

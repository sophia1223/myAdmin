@if(checkPermission('admin.'.$table.'.create'))
    <a href="javascript:" class="btn btn-primary" id="add-record">
        <i class="fa fa-plus"></i>
        新增
    </a>
@endif
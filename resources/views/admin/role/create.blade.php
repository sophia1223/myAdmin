<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">新增角色</h3>
        <button id="record-list" type="button" class="btn btn-box-tool">
            <i class="fa fa-mail-reply text-blue"> 返回列表</i>
        </button>
    </div>
    <form class="form-horizontal" id="formRole">
        @include('admin.role.create_edit')
    </form>
</div>
<script>
    $(crud.create('formRole','roles'));
</script>
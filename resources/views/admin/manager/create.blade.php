<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">新增管理员</h3>
    </div>
    <form class="form-horizontal" id="formManager">
        @include('admin.manager.create_edit')
    </form>
</div>
<script>
    $(crud.create('formManager','admins'));
</script>
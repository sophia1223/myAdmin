<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">编辑管理员</h3>
    </div>
    <form class="form-horizontal" id="formManager">
        <input type="hidden" name="id" id="id" value="{{ $admin->id or '' }}">
        @include('admin.manager.create_edit')
    </form>
</div>
<script>
    $(crud.edit('formManager','admins'));
</script>
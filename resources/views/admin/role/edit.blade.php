<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">编辑角色</h3>
    </div>
    <form class="form-horizontal" id="formRole">
        <input type="hidden" name="id" id="id" value="{{ $role->id or '' }}">
        @include('admin.role.create_edit')
    </form>
</div>
<script>
    $(crud.edit('formRole','roles'));
</script>
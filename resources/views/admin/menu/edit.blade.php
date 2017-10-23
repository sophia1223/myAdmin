<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">编辑菜单</h3>
    </div>
    <form class="form-horizontal" id="formMenu">
        <input type="hidden" name="id" id="id" value="{{ $menu->id or '' }}">
        @include('admin.menu.create_edit')
    </form>
</div>
<script>
    $(crud.edit('formMenu','menus'));
</script>
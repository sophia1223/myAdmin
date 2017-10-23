<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">新增菜单</h3>
    </div>
    <form class="form-horizontal" id="formMenu">
        @include('admin.menu.create_edit')
    </form>
</div>
<script>
    $(crud.create('formMenu','menus'));
</script>
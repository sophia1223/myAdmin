<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">新增banner</h3>
    </div>
    <form class="form-horizontal" id="formBanner">
        @include('admin.banner.create_edit')
    </form>
</div>
<script>
    $(crud.create('formBanner','banners'));
</script>
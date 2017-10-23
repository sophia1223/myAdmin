<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">编辑banner</h3>
    </div>
    <form class="form-horizontal" id="formBanner">
        <input type="hidden" name="id" id="id" value="{{ $banner->id or '' }}">
        <input type="hidden" name="old_path" id="old_path" value="{{ $banner->path or '' }}">
        @include('admin.banner.create_edit')
    </form>
</div>
<script>
    $(crud.edit('formBanner','banners'));
</script>
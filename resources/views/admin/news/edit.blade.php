<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">编辑新闻</h3>
    </div>
    <form class="form-horizontal" id="formNews">
        <input type="hidden" name="id" id="id" value="{{ $news->id or '' }}">
        <input type="hidden" name="old_path" id="old_path" value="{{ $news->image or '' }}">
        <input type="hidden" name="status" id="status" value="0">
        @include('admin.news.create_edit')
    </form>
</div>
<script>
    $(crud.edit('formNews','news'));
</script>
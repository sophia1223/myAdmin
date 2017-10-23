<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">新增新闻</h3>
    </div>
    <form class="form-horizontal" id="formNews">
        @include('admin.news.create_edit')
    </form>
</div>
<script>
    $(crud.create('formNews','news'));
</script>
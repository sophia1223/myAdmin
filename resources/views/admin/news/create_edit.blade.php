<div class="box-body">
    <div class="form-group">
        <label class="col-sm-4 control-label">标题：</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="title" id="title"
                   required="true"
                   placeholder="新闻标题" value="{{ $news->title or '' }}">
        </div>
    </div>
    <div class="form-group">
        <label for="image" class="col-sm-4 control-label">图片：</label>
        <div class="col-sm-4" id="tips" style="height: 34px;line-height: 34px">
            <span class="text-blue">
                tips：图片格式支持jpg、gif，大小不能超过1MB
            </span>
        </div>
        <div class="col-sm-5 col-sm-offset-4">
            <input type="file" class='fileImg' id="image" name="image"
                   @if(!isset($news))
                   required="true"
                   @endif
                   accept="image/gif, image/jpeg"/>
            @if(isset($news))
                <img src="{{ asset("storage/{$news->image}") }}" id="old_img" style="width:200px; height: 120px;max-width: 200px;max-height: 120px;">
            @endif
            <div id="preview">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">新闻类型</label>
        <div class="col-sm-4">
            <select class="select2 form-control" name="news_type_id" id="news_type_id">
                @foreach($newsTypes as $key => $name)
                    <option value="{{ $key }}" @if(isset($news)) @if($news->news_type_id == $key) selected @endif @endif >{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-4 control-label">内容</label>
        <div class="col-sm-5">
            <textarea id="container" name="content" type="text/plain">{!! $news->content or '' !!}</textarea>
        </div>
    </div>
</div>
@include('admin.partials.form_buttons')
<script>
    $(function () {
        $('#image').change(function () {
            preview(this);
        });

        function preview(file) {
            var prevDiv = document.getElementById('preview');
            if (file.files && file.files[0]) {
                var reader = new FileReader();
                reader.onload = function (evt) {
                    $('#old_img').remove();
                    prevDiv.style.display = 'block';
                    prevDiv.innerHTML = '<img src="' + evt.target.result + '" />';
                };
                reader.readAsDataURL(file.files[0]);
            }
            else {
                prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\';"></div>';
            }
        }
    });

</script>
<div class="box-body">
    <div class="form-group">
        <label for="image" class="col-sm-4 control-label">图片：</label>
        <div class="col-sm-4" id="tips" style="height: 34px;line-height: 34px">
            <span class="text-blue">
                tips：图片格式支持jpg、gif，大小不能超过2MB
            </span>
        </div>
        <div class="col-sm-5 col-sm-offset-4">
            <input type="file" class='fileImg' id="path" name="path"
                   @if(!isset($banner))
                   required="true"
                   @endif
                   accept="image/gif, image/jpeg,image/png"/>
            @if(isset($banner))
                <img src="{{asset("storage/{$banner->image}")}}" id="old_img" style="width:200px; height: 120px;max-width: 200px;max-height: 120px;">
            @endif
            <div id="preview">
            </div>
        </div>

    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">所属位置：</label>
        <div class="col-sm-4">
            <select class="select2 form-control" name="belongs" id="belongs">
                <option value="0" @if(isset($banner)) @if($banner->belongs == 0) selected @endif @endif>首页</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">备注：</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="remark" id="remark"
                   placeholder="备注" value="{{ $banner->remark or '' }}">
        </div>
    </div>
</div>
@include('admin.partials.form_buttons')
<script>
    $(function () {
        $('#path').change(function () {
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
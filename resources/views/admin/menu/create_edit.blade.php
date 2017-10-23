<div class="box-body">
    <div class="form-group">
        <label class="col-sm-4 control-label">菜单名称</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="name" id="name"
                   placeholder="菜单名称"
                   required="true"
                   value="{{ $menu->name or '' }}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">父级菜单</label>
        <div class="col-sm-4">
            <select class="select2 form-control" name="p_id" id="p_id">
                <option value="0">（顶级）</option>
                @foreach($menus as $key => $name)
                    @if(isset($menu))
                    @if($menu->id != $key )
                    <option value="{{ $key }}"  @if($menu->p_id == $key) selected @endif  >{{ $name }}</option>
                    @endif
                    @else
                    <option value="{{ $key }}">{{ $name }}</option>
                    @endif

                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group" id="change-show">
        <label class="col-sm-4 control-label">功能</label>
        <div class="col-sm-4">
            <select class="select2 form-control" name="permission_id" id="permission_id">
                @foreach($permissions as $key => $permission)
                    <option value="{{ $key }}" @if(isset($menu)) @if($menu->permission_id == $key) selected @endif @endif >{{ $permission }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4" id="tips" style="display: none;height: 34px;line-height: 34px">
            <span class="text-blue">
                tips：顶级菜单如有子菜单，则功能无效
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">菜单图标</label>
        <div class="col-sm-4">
            <!-- Button tag -->
            <input type="text" name="icon" id="iconpicker"
                   data-icon="@if(isset($menu->icon)) {{ $menu->icon }} @else fa-sliders @endif"
                   value="@if(isset($menu->icon)) {{ $menu->icon }} @endif"
            />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">排序</label>
        <div class="col-sm-4">
            <input type="number" class="form-control" name="sort" id="sort"
                   placeholder="排序（从小到大）"
                   required="required" value="{{ $menu->sort or '' }}">
        </div>
    </div>
</div>
@include('admin.partials.form_buttons')
<script>
    $(function () {
        $('#iconpicker').fontIconPicker({
            source: fa_icons,
            searchSource: fa_icons,
            theme: 'fip-bootstrap',
            emptyIconValue: 'none'
        });

        $(".selected-icon").html('<i class="@if(isset($menu->icon)) {{ $menu->icon }} @else fip-icon-block @endif"></i>');

        //显示tips
        changeTips();
        $('#p_id').change(function () {
            changeTips();
        });
        function changeTips() {
            if($('#p_id').val() === '0'){
                $('#tips').show();
            }else{
                $('#tips').hide();
            }
        }
    });

</script>
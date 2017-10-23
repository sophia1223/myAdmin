<div class="box-body">
    <div class="form-group">
        <label class="col-sm-4 control-label">角色名称</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="name" id="name"
                   placeholder="角色名称"
                   required="true"
                   maxlength="40"
                   value="{{ $role->name or '' }}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">标签</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="label" id="label"
                   required="true"
                   placeholder="标签"
                   maxlength="40"
                   value="{{ $role->label or '' }}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">描述</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="description" id="description"
                   placeholder="描述"
                   value="{{ $role->description or '' }}">
        </div>
    </div>
    <div class="form-group" id="change-show">
        <label class="col-sm-4 control-label">分配权限</label>
        <div class="col-sm-4">
            <ul id="roleTree" class="ztree"></ul>
            <input type="hidden" name="permissions" id="roleId">
        </div>
    </div>
</div>
@include('admin.partials.form_buttons')
<script>
    $(function () {

        var setting = {
            view: {
                selectedMulti: false
            },
            check: {
                enable: true,
                chkboxType: {"Y" : "ps", "N" : "s"},
                autoCheckTrigger: false
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                onCheck: onCheck
            }
        };
        var zNodes = {!! $permissions !!};
//        zTree init
        $.fn.zTree.init($("#roleTree"), setting, zNodes);
//        获取checked id
        var $roleId = $("#roleId");
        var arr = [];

        function onCheck(event, treeId, treeNode) {
            var treeObj = $.fn.zTree.getZTreeObj("roleTree");
            var nodes = treeObj.transformToArray(treeObj.getNodes());
            if (arr.length !== 0) {
                arr = [];
            }
            for (var i = 0; i < nodes.length; i++) {
                if (nodes[i].checked) {
                    arr.push(nodes[i].id);
                }
            }
            arr.shift();
            $roleId.val(arr);
        }
    });
</script>

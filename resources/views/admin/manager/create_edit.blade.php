<div class="box-body">
    <div class="form-group">
        <label class="col-sm-4 control-label">管理员账号</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="username" id="username"
                   placeholder="管理员账号"
                   required="true"
                   value="{{ $admin->username or '' }}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">管理员实名</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="realname" id="realname"
                   placeholder="管理员实名"
                   required="true"
                   value="{{ $admin->realname or '' }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">分配角色</label>
        <div class="col-sm-4">
            <select name="roles[]" required="true" class="select2 form-control" multiple>
                @foreach($roles as $key => $name)
                    <option value="{{ $key }}"
                            @if(isset($admin)) @if($admin->roles->contains('id',$key)) selected @endif @endif >{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">密码</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" name="password" id="password" value="" autofocus>
        </div>
        <div class="col-sm-4" id="tips" style="height: 34px;line-height: 34px">
            <span class="text-blue">
                密码至少6位，为字母数字组合
            </span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4 control-label">密码确认</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value=""
                   data-parsley-equalto="#password" autofocus>
        </div>
    </div>
</div>
@include('admin.partials.form_buttons')
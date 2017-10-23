<div class="activityBox showBox">
    <h3>{{ $news->title }}</h3>
    <p class="fromStyle">
        <span>来自于：</span>
        <a href="#" class="text-blue">XXXXX </a>
        <i class="divider">|</i>
        <span>发布人：</span>
        <a href="#" class="text-blue">{{ $news->admin->realname }} </a>
        <i class="divider">|</i>
        <span>分类：</span>
        <a href="#" class="text-blue">{{ $news->news_type->name }}</a>
    </p>
    <div class="infoBox">
        <div class="leftImg pull-left">
            <img src="{{ asset("uploads/{$news->image}") }}">
        </div>
        <div class="rightInfo pull-left">
            <div class="list-seperator"></div>
            <div class="infoDetail clearfix">
                <ul style="margin-left: 30%;width: 70%;">
                    <li>
                        <i class="fa fa-group"></i>
                        点击数：
                        <span>{{ $news->hits }}</span>
                    </li>
                    <li>
                        <i class="fa fa-calendar-check-o"></i>
                        新闻创建时间：
                        <span>{{ $news->created_at }}</span>
                    </li>
                    <li>
                        <i class="fa fa-calendar-o"></i>
                        新闻修改时间：
                        <span>{{ $news->updated_at }}</span>
                    </li>
                    <li>
                        <i class="fa fa-balance-scale"></i>
                        新闻审核状态：
                        <span>
                            @switch($news->status)
                                @case(0)
                                未审核
                                @break

                                @case(1)
                                通过
                                @break

                                @case(2)
                                拒绝
                                @break

                                @default
                                !出错!
                            @endswitch
                        </span>
                    </li>
                    @if($news->status!==0 && !empty($news->reply))
                        <li>
                            <i class="fa fa-reply"></i>
                            审批回复：
                            <span>{{ $news->reply }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!--新闻内容-->
<div class="detailBox showBox">
    <h3>新闻内容</h3>
    <div class="detailContent">
        {!! $news->content !!}
    </div>
</div>
<!--新闻审批-->
@if($news->status===0 && checkPermission('admin.news.approval'))
<div class="showBox replyBox">
    <h3>审批</h3>
    <form id="formNewsApproval" class="form-horizontal">
        <div class="form-group">
            <label for="isOn" class="control-label col-sm-2">是否通过:</label>
            <div class="col-sm-4">
                <input id="isOn" name="status" type="checkbox" class="js-switch form-control " />
            </div>
        </div>
        <div class="form-group">
            <label for="isOn" class="control-label col-sm-2">回复：</label>
            <div class="col-sm-10">
                <div class="textarea">
                    <input type="hidden" name="id" id="id" value="{{ $news->id }}">
                    <textarea name="reply" required="true"></textarea>
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary pull-right" value="提交回复">
    </form>
</div>
<script>
    $(crud.approval('formNewsApproval','news'));
</script>
@endif



<style>
	.modalContent {
		border-radius: 10px;
	}

	.modalFooter {
		border-radius: 0 0 10px 10px;
	}
</style>
<div class="modal fade" tabindex="-1" role="dialog" id="updatePassword">
	<div class="modal-dialog" role="document">
		<div class="modal-content modalContent">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">修改密码</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="validation-form" method="post" action="">
					<div class="form-group">
						<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">原密码</label>

						<div class="col-xs-12 col-sm-9">
							<div class="clearfix">
								<input type="password" name="password" id="password" class="col-xs-12 col-sm-6" />
							</div>
						</div>
					</div>

					<div class="space-2"></div>

					<div class="form-group">
						<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="newPassword">新密码</label>

						<div class="col-xs-12 col-sm-9">
							<div class="clearfix">
								<input type="password" name="newPassword" id="newPassword" class="col-xs-12 col-sm-6" />
							</div>
						</div>
					</div>

					<div class="space-2"></div>

					<div class="form-group">
						<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="rePassword">重复密码</label>

						<div class="col-xs-12 col-sm-9">
							<div class="clearfix">
								<input type="password" name="rePassword" id="rePassword" class="col-xs-12 col-sm-6" />
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer modalFooter">
				<button type="button" class="btn btn-default modalContent" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary modalContent" id="save">保存</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	$(function() {
		$("#updatePassword").on('hide.bs.modal', function() {
			$("#validation-form")[0].reset();
		});

		$('#save').click(function() {
			var newPassword = $("#newPassword").val();
			var rePassword = $("#rePassword").val();
			if (newPassword !== rePassword) {
				alert('两次密码输入不一致');
				return false;
			}
			var password = $("#password").val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "{{ url('admin/updatePassword') }}",
                data: {'password': password,
                    'newPassword': newPassword,
                    'rePassword': rePassword,
                    '_token': "{{ csrf_token() }}" } ,
                success: function (result) {
                    page.inform(
                        '操作结果', result.message,
                        result.statusCode === 200 ? page.success : page.failure
                    );
                    $("#updatePassword").modal('hide');
                    return false;
                },
                error: function (e) {
                    var obj = JSON.parse(e.responseText);
                    page.inform('出现异常', obj['message'], page.failure);
                }
            });
		});
	});
</script>
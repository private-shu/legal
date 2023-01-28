<div class="container pt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('アカウント情報修正') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="user-name" class="col col-sm-4 col-form-label text-md-end required">{{ __('アカウント名') }}</label>
                            <div class="col-md-6">
                                <input id="userName" type="text" class="form-control user-name" name="userName" value="{{ $user->name }}" required autofocus disabled>
                                @if ($errors->has('userName'))
                                    <li class="text-danger">{{$errors->first('userName')}}</li>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user-email" class="col col-sm-4 col-form-label text-md-end required">{{ __('メールアドレス') }}</label>
                            <div class="col-md-6">
                                <input id="userEmail" type="email" class="form-control user-email" name="userEmail" value="{{  $user->email }}" required autofocus disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user-password" class="col col-sm-4 col-form-label text-md-end required">{{ __('パスワード') }}</label>
                            <div class="col-md-6">
                                <input id="userPassword" type="password" class="form-control user-password" name="userPassword" value="●●●●●●●●" required autofocus disabled>
                            </div>
                            <div class="col-md-1 form-check">
                                <input id="editUserPasswordCheck" type="checkbox" class="form-control form-check-input edit-user-password-check" aria-label="checkbox for password text input" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user-role" class="col col-sm-4 col-form-label text-md-end required">{{ __('権限') }}</label>
                            <div class="col-md-6">
                                <select class="form-select form-select user-role" aria-label=".form-select user-role" name="userRole" required autofocus disabled>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? "selected" : "" }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row pt-3 justify-content-end">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6 pt-2 btn-group justify-content-end">
                                <div class='btn-toolbar' role="toolbar">
                                    <button type="button" class="btn btn-outline-primary btn-sm text-nowrap mr-1" id="userEditButton">アカウント情報修正</button>
                                    <div class="btn-group btn-update-cancel" role="group">
                                        <button type="submit" formaction="{{ route('user.update') }}" class="btn btn-outline-success btn-sm text-nowrap" id="userUpdateButton">アカウント情報更新</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm text-nowrap" id="userCancelButton">キャンセル</button>
                                    </div>
                                    <button type="submit" formaction="{{ route('user.delete') }}" class="btn btn-outline-danger btn-sm text-nowrap" id="userDelButton">アカウント削除</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="userId" value={{ $user->id }}>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".btn-update-cancel").hide();
    });
    
    $(document).on("click", "#userEditButton", function () {
        $("#userEditButton").hide();
        $("#userDelButton").hide();
        $(".btn-update-cancel").show();
    
        $(".user-name").attr("disabled", false);
        $(".user-email").attr("disabled", false);
        $(".edit-user-password-check").attr("disabled", false);
        // $(".user-password").attr("disabled", false);
        // $(".user-role").attr("disabled", false);
        // $(".user-password").val("");
    });
    
    $(document).on("click", "#editUserPasswordCheck", function () {
        let check_status = $(this).prop("checked");
        if (check_status) {
            $(".user-password").attr("disabled", false);
            $(".user-password").val("");
        } else {
            $(".user-password").attr("disabled", true);
            $(".user-password").val("●●●●●●●●");
        }
    });

    $(document).on("click", "#userCancelButton", function () {
        // 未保存内容ある場合、残されるままになるため、reloadさせる
        if (confirm("修正をキャンセルします。よろしいですか？")) {
            location.reload();
        }
    });
    
    $(document).on("click", "#userUpdateButton", function () {
        return confirm("更新処理を行います。よろしいですか？");
    });

    $(document).on("click", "#userDelButton", function () {
        return confirm("削除処理を行います。よろしいですか？");
    });
    
    @if (session('message'))
        $(function () {
            toastr.success('{{ session('message') }}');
        });
    @endif
    </script>
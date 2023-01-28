<div class="container-fluid overflow-auto" style="height: 980px;">
    <form method="POST" action="{{ route('contract.store') }}">
        <!-- CSRF保護 -->
        @csrf
        <p class="mt-4 pb-2 font-weight-bold display-8" style="font-size:17px;"><i class="fa-solid fa-person-circle-exclamation fa-lg pr-1"></i>お客様基本情報</p>
        <div class="container-fluid pl-4 member-info-container-style" id="memberContainer">
            <div class="row pb-3 pt-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="name" class="col col-sm-4 col-form-label text-md-end required">{{ __('お名前') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control name" name="name" value="{{ $member->name }}" disabled>
                            <span class="invalid-feedback" role="alert">{{$errors->first('name')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="gender" class="col col-sm-4 col-form-label text-md-end required">{{ __('性別') }}</label>
                        <div class="col-sm-8 d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input gender" type="radio" name="gender" id="male" value="1" {{ $member->gender == 1 ? "checked" : ""}} disabled>
                                <label class="form-check-label" for="inlineRadioMale">男</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input gender" type="radio" name="gender" id="female" value="2" {{ $member->gender == 2 ? "checked" : ""}} disabled>
                                <label class="form-check-label" for="inlineRadioFemale">女</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3 pt-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="birth_date" class="col col-sm-4 col-form-label text-md-end">{{ __('生年月日') }}</label>
                        <div class="col-sm-8">
                            <input type="date" class="input-sm form-control birth_date" name="birthDate" value="{{ $member->birth_date }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="tel" class="col col-sm-4 col-form-label text-md-end">{{ __('電話番号') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control tel" name="tel" value="{{ $member->tel }}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="current_residence" class="col col-sm-4 col-form-label text-md-end required">{{ __('在留資格') }}</label>
                        <div class="col-sm-8">
                            <select class="form-select form-select current_residence" aria-label=".form-select current_residence" name="currentResidence" disabled>
                                <option value="">選択して下さい</option>
                                @foreach($current_residence_types as $current_residence_type)
                                    <option value="{{ $current_residence_type->id }}" {{ $member->current_residence == $current_residence_type->id ? "selected" : "" }}>
                                        {{ $current_residence_type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="company" class="col col-sm-4 col-form-label text-md-end">{{ __('会社') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control company" name="company" value="{{ $member->company }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="related_personnel" class="col col-sm-4 col-form-label text-md-end">{{ __('関連人員') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control related_personnel" name="relatedPersonnel" value="{{ $member->related_personnel }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
            </div>
            <div class="row pb-3">
                <div class="col">
                    <div class="row justify-content-start">
                        <label for="detailed_information" class="col col-sm-1 col-form-label text-md-end">{{ __('詳細内容') }}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control detailed_information" name="detailedInformation" rows="6" disabled>{{ $member->detailed_information }}</textarea>
                        </div>
                        <div class="col-sm-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3 justify-content-end">
            <div class="col-sm-9"></div>
            <div class="col-sm-3 pt-2 btn-group justify-content-end">
                <div class='btn-toolbar' role="toolbar">
                    <button type="button" class="btn btn-outline-primary btn-sm text-nowrap mr-1" id="memberEditButton">お客様情報修正</button>
                    <div class="btn-group btn-update-cancel" role="group">
                        <button type="submit" formaction="{{ route('member.update') }}" class="btn btn-outline-success btn-sm text-nowrap" id="memberUpdateButton">お客様情報更新</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm text-nowrap" id="memberCancelButton">キャンセル</button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="memberId" value={{ $member->id }}>
    </form>
</div>

<script>
    $(document).ready(function() {
        $(".btn-update-cancel").hide();
    });
    
    $(document).on("click", "#memberEditButton", function () {
        $("#memberEditButton").hide();
        $("#memberDelButton").hide();
        $(".btn-update-cancel").show();
    
        $(".name").attr("disabled", false);
        $(".gender").attr("disabled", false);
        $(".birth_date").attr("disabled", false);
        $(".tel").attr("disabled", false);
        $(".current_residence").attr("disabled", false);
        $(".company").attr("disabled", false);
        $(".related_personnel").attr("disabled", false);
        $(".detailed_information").attr("disabled", false);
    });
    
    $(document).on("click", "#memberCancelButton", function () {
        // 未保存内容ある場合、残されるままになるため、reloadさせる
        if (confirm("修正をキャンセルします。よろしいですか？")) {
            location.reload();
        }
    });
    
    $(document).on("click", "#memberUpdateButton", function () {
        return confirm("更新処理を行います。よろしいですか？");
    });
    
    @if (session('message'))
        $(function () {
            toastr.success('{{ session('message') }}');
        });
    @endif
    </script>
    
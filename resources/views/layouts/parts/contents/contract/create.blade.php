<div class="container-fluid overflow-auto" style="height: 980px;">
    <form method="POST" action="{{ route('contract.store') }}">
        <!-- CSRF保護 -->
        @csrf
        <div class="text-right p-0 pt-2">
            <button type="submit" class="btn btn-outline-danger btn-sm contract-create-button" id="createContractButton">入力内容保存</button>
        </div>
        <p class="mb-0 pb-2 font-weight-bold display-8" style="font-size:17px;"><i class="fa-solid fa-person-circle-exclamation fa-lg pr-1"></i>お客様基本情報</p>
        <div class="container-fluid pl-4 member-info-container-style" id="memberContainer">
            <div class="row pb-3 pt-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="reception_date" class="col col-sm-4 col-form-label text-md-end required">{{ __('受付年月日') }}</label>
                        <div class="col-sm-8">
                            <input type="date" class="input-sm form-control reception_date" name="receptionDate" value="{{ old('receptionDate') }}" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <input type="hidden" name="loginUser" value={{ Auth::user()->id }}>
                        <label for="receptionist" class="col col-sm-4 col-form-label text-md-end required">{{ __('受付担当者') }}</label>
                        <div class="col-sm-8">
                            <select class="form-select form-select receptionist" aria-label=".form-select current_residence" name="receptionist" required {{ Auth::user()->role_id <> 1 ? "disabled" : ""}} >
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ Auth::id() == $user->id ? "selected" : "" }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
            </div>
            <div class="row pb-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="name" class="col col-sm-4 col-form-label text-md-end required">{{ __('お名前') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control name" name="name" value="{{ old('name') }}" required autocomplete="off">
                            <span class="invalid-feedback" role="alert">{{$errors->first('name')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="gender" class="col col-sm-4 col-form-label text-md-end required">{{ __('性別') }}</label>
                        <div class="col-sm-8 d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input gender" type="radio" name="gender" id="male" value="1" checked>
                                <label class="form-check-label" for="inlineRadioMale">男</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input gender" type="radio" name="gender" id="female" value="2">
                                <label class="form-check-label" for="inlineRadioFemale">女</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="birth_date" class="col col-sm-4 col-form-label text-md-end">{{ __('生年月日') }}</label>
                        <div class="col-sm-8">
                            <input type="date" class="input-sm form-control birth_date" name="birthDate" value="{{ old('birthDate') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="tel" class="col col-sm-4 col-form-label text-md-end">{{ __('電話番号') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control tel" name="tel" value="{{ old('tel') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="current_residence" class="col col-sm-4 col-form-label text-md-end required">{{ __('在留資格') }}</label>
                        <div class="col-sm-8">
                            <select class="form-select form-select current_residence" aria-label=".form-select current_residence" name="currentResidence" required>
                                <option value="">選択して下さい</option>
                                @foreach($current_residence_types as $current_residence_type)
                                    <option value="{{ $current_residence_type->id }}">
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
                            <input type="text" class="input-sm form-control company" name="company" value="{{ old('company') }}" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row justify-content-start">
                        <label for="related_personnel" class="col col-sm-4 col-form-label text-md-end">{{ __('関連人員') }}</label>
                        <div class="col-sm-8">
                            <input type="text" class="input-sm form-control related_personnel" name="relatedPersonnel" value="{{ old('relatedPersonnel') }}" autocomplete="off">
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
                            <textarea class="form-control detailed_information" name="detailedInformation" value="{{ old('detailedInformation') }}" rows="3"></textarea>
                        </div>
                        <div class="col-sm-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="mt-4 mb-0 pb-2 font-weight-bold display-8" style="font-size:17px;"><i class="fa-solid fa-file-contract fa-lg pr-1"></i>契約情報</p>
        <div class="container-fluid p-0 pb-3 m-0 agreement-info-container-style" id="agreementContainer">
            <div class="row row p-0 m-0">
                <div class="col-sm-11"></div>
                <div class="col-sm-1">
                    <button type="button" class="btn btn-outline-success btn-sm contract-add-button" id="addContractButton">契約内容追加</button>
                </div>
            </div>
            <div class="row p-0 m-0">
                <div class="col p-0 m-0">
                    <div class="container m-0 mb-2 contact-info-container-style contact-content" id="contactContent_1" data-index=1>
                        <div class="row pt-3">
                            <div class="col-sm-4">
                                <div class="row justify-content-start">
                                    <label for="management-number" class="col col-sm-4 col-form-label text-md-end required">{{ __('管理番号') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control management-number" name="managementNumber[]" value="{{ old('managementNumber') }}" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row pt-3">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="contract-type" class="col col-sm-4 col-form-label text-md-end required">{{ __('契約内容') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select contract-type" aria-label=".form-select contract-type" name="contactType[]" required>
                                            <option value="">選択して下さい</option>
                                            @foreach($contract_types as $contract_type)
                                                <option value="{{ $contract_type->id }}">
                                                    {{ $contract_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <div class="col">
                                        <select class="form-select form-select residence-type" aria-label=".form-select residence-type" name="residenceType[]" required>
                                            <option value="">選択して下さい</option>
                                            @foreach($application_residence_types as $application_residence_type)
                                                <option value="{{ $application_residence_type->id }}">
                                                    {{ $application_residence_type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="start-fee-payment-amount" class="col col-sm-4 col-form-label text-md-end required">{{ __('着手金') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control start-fee-payment-amount" name="startFeePaymentAmount[]" value="{{ old('startFeePaymentAmount') }}" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="start-fee-payment-method" class="col col-sm-4 col-form-label text-md-end">{{ __('支払い方法') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select start-fee-payment-method" aria-label=".form-select start-fee-payment-method" name="startFeePaymentMethod[]" autocomplete="off">
                                            <option value="">選択して下さい</option>
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}">
                                                    {{ $payment_method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="start-fee-payment-date" class="col col-sm-4 col-form-label text-md-end">{{ __('支払日') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="input-sm form-control start-fee-payment-date" name="startFeePaymentDate[]" value="{{ old('startFeePaymentDate') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="start-fee-total-amount" class="col col-sm-4 col-form-label text-md-end">{{ __('支払金額') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control start-fee-total-amount" name="startFeeTotalAmount[]" value="{{ old('startFeeTotalAmount') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm">
                                <div class="row justify-content-start">
                                    <label for="start-fee-payment-comment" class="col col-sm-4 col-form-label text-md-end">{{ __('備考※') }}</label>
                                    <div class="col-sm-8">
                                        <textarea class="input-sm form-control start-fee-payment-comment" name="startFeePaymentComment[]" value="{{ old('startFeePaymentComment') }}" rows="2" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-amount" class="col col-sm-4 col-form-label text-md-end">{{ __('成功金') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control success-fee-payment-amount" name="successFeePaymentAmount[]" value="{{ old('successFeePaymentAmount') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-method" class="col col-sm-4 col-form-label text-md-end">{{ __('支払い方法') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select success-fee-payment-method" aria-label=".form-select success-fee-payment-method" name="successFeePaymentMethod[]" autocomplete="off">
                                            <option value="">選択して下さい</option>
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}">
                                                    {{ $payment_method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-date" class="col col-sm-4 col-form-label text-md-end">{{ __('支払日') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="input-sm form-control success-fee-payment-date" name="successFeePaymentDate[]" value="{{ old('successFeePaymentDate') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-total-amount" class="col col-sm-4 col-form-label text-md-end">{{ __('支払金額') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control success-fee-total-amount" name="successFeeTotalAmount[]" value="{{ old('successFeeTotalAmount') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-comment" class="col col-sm-4 col-form-label text-md-end">{{ __('備考※') }}</label>
                                    <div class="col-sm-8">
                                        <textarea class="input-sm form-control success-fee-payment-comment" name="successFeePaymentComment[]" value="{{ old('successFeePaymentComment') }}" autocomplete="off" row="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row pb-3">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-number" class="col col-sm-4 col-form-label text-md-end">{{ __('申請番号') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control application-number" name="applicationNumber[]" value="{{ old('applicationNumber') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-date" class="col col-sm-4 col-form-label text-md-end">{{ __('申請日') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="input-sm form-control application-date" name="applicationDate[]" value="{{ old('applicationDate') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-document" class="col col-sm-4 col-form-label text-md-end">{{ __('申請書類') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control application-document" name="applicationDocumente[]" value="{{ old('applicationDocumente') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="additional-document" class="col col-sm-4 col-form-label text-md-end">{{ __('追加資料') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control additional-document" name="additionalDocument[]" value="{{ old('additionalDocument') }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-status" class="col col-sm-4 col-form-label text-md-end">{{ __('申請結果') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select application-status" name="applicationStatus[]" value="{{ old('applicationStatus') }}" autocomplete="off">
                                            <option value="">選択して下さい</option>
                                            @foreach($application_statuses as $application_status)
                                                <option value="{{ $application_status->id }}">
                                                    {{ $application_status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1 text-right">
                               <button type="button" data-toggle="tooltip" data-placement="top" title="契約内容削除" class="btn btn-outline-danger btn-sm contract-del-button" id="deleteContractButton" data-index=1 disabled><i class="fas fa-minus-circle"></i></button>
                            </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="contractCount" value=1>
    </form>
</div>

<script>
    $(document).on("click", ".contract-add-button", function () {
        var contactContents = $(".contact-content");
        // 一番最後の契約内容を取得
        var sourceContactTemplate = contactContents.last();
        // data-indexを設定
        var sourceContactTemplateIndex = $(sourceContactTemplate).attr("data-index");
        var cloneContactTemplate = $(sourceContactTemplate).clone(true);
        var cloneContactTemplateIndex = Number(sourceContactTemplateIndex) + 1;
        $(cloneContactTemplate).attr("data-index", cloneContactTemplateIndex);
        $(cloneContactTemplate).attr("id", "contactContent_" + cloneContactTemplateIndex);
        $(cloneContactTemplate).find(".contract-del-button").attr("data-index", cloneContactTemplateIndex);
        // 値をクリアする
        $(cloneContactTemplate).find(".management-number").val("");
        $(cloneContactTemplate).find(".start-fee-payment-amount").val("");
        $(cloneContactTemplate).find(".start-fee-payment-method").val("");
        $(cloneContactTemplate).find(".start-fee-payment-date").val("");
        $(cloneContactTemplate).find(".start-fee-total-amount").val("");
        $(cloneContactTemplate).find(".start-fee-payment-comment").val("");
        $(cloneContactTemplate).find(".success-fee-payment-amount").val("");
        $(cloneContactTemplate).find(".success-fee-payment-method").val("");
        $(cloneContactTemplate).find(".success-fee-payment-date").val("");
        $(cloneContactTemplate).find(".success-fee-total-amount").val("");
        $(cloneContactTemplate).find(".success-fee-payment-comment").val("");
        $(cloneContactTemplate).find(".application-number").val("");
        $(cloneContactTemplate).find(".application-date").val("");
        $(cloneContactTemplate).find(".application-document").val("");
        $(cloneContactTemplate).find(".additional-document").val("");

        cloneContactTemplate.insertAfter(sourceContactTemplate);
        // 削除ボタンをenableにする
        var newContactContents = $(".contact-content");
        if (newContactContents.length > 1) {
            $(".contract-del-button").attr('disabled', false);
        };

        // 契約内容カウント数を設定する
        $('input:hidden[name="contractCount"]').val(newContactContents.length);
    });

    $(document).on("click", ".contract-del-button", function () {
        var contactIndex = $(this).data("index");
        if(!confirm("契約内容を削除します。宜しいでしょうか？")) {
            return false;
        } else {
            // 契約内容削除
            $("#contactContent_" + contactIndex).remove();
            // 残契約内容id振り直す
            $(".contact-content").each(function(index, element) {
                contactContentIndex = index + 1;
                $(element).attr("id", "contactContent_" + contactContentIndex);
                $(element).attr("data-index", contactContentIndex);
                $(element).find(".contract-del-button").attr("data-index", contactContentIndex);
            });
            // 残契約内容削除ボタン判定
            var newContactContents = $(".contact-content");
            if (newContactContents.length == 1) {
                $(".contract-del-button").attr('disabled', true);
            };

            // 契約内容カウント数を設定する
            $('input:hidden[name="contractCount"]').val(newContactContents.length);
        }
    });
</script>
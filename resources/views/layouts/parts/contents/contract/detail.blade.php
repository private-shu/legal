<div class="container-fluid overflow-auto" style="height: 980px;">
    <form method="POST">
        <!-- CSRF保護 -->
        @csrf
        <p class="mt-4 mb-0 pb-2 font-weight-bold display-8" style="font-size:17px;"><i class="fa-solid fa-file-contract fa-lg pr-1"></i>契約情報</p>
        <div class="container-fluid p-0 pb-3 m-0 agreement-info-container-style" id="agreementContainer">
            <div class="row p-0 m-0">
                <div class="col p-0 m-0">
                    <div class="container m-0 mb-2 contact-info-container-style contact-content" id="contactContent">
                        <div class="row pt-3">
                            <div class="col-sm-4">
                                <div class="row justify-content-start">
                                    <label for="management-number" class="col col-sm-4 col-form-label text-md-end required">{{ __('管理番号') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control management-number" name="managementNumber" value="{{ $contract->management_number }}" disabled required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="reception-date" class="col col-sm-4 col-form-label text-md-end">{{ __('受付年月日') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="input-sm form-control reception-date" name="receptionDate" value="{{ $contract->reception_date }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="receptionist" class="col col-sm-4 col-form-label text-md-end">{{ __('受付担当者') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select receptionist" aria-label=".form-select receptionist" name="receptionist"  {{ Auth::user()->role_id <> 1 ? "disabled" : ""}} disabled>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == $contract->receptionist ? "selected" : "" }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <select class="form-select form-select contract-type" aria-label=".form-select contract-type" name="contactType" disabled required>
                                            <option value="">選択して下さい</option>
                                            @foreach($contract_types as $contract_type)
                                                <option value="{{ $contract_type->id }}" {{ $contract_type->id == $contract->contract_type_id ? "selected" : "" }}>
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
                                        <select class="form-select form-select residence-type" aria-label=".form-select residence-type" name="residenceType" disabled required>
                                            <option value="">選択して下さい</option>
                                            @foreach($application_residence_types as $application_residence_type)
                                                <option value="{{ $application_residence_type->id }}" {{ $application_residence_type->id == $contract->residence_type_id ? "selected" : "" }}>
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
                                        <input type="number" class="input-sm form-control start-fee-payment-amount" name="startFeePaymentAmount" value="{{ $contract->start_fee_payment_amount }}" disabled required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="start-fee-payment-method" class="col col-sm-4 col-form-label text-md-end">{{ __('支払い方法') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select start-fee-payment-method" aria-label=".form-select start-fee-payment-method" name="startFeePaymentMethod" disabled>
                                            <option value="">選択して下さい</option>
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}" {{ $payment_method->id == $contract->start_fee_payment_method_id ? "selected" : "" }}>
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
                                        <input type="date" class="input-sm form-control start-fee-payment-date" name="startFeePaymentDate" value="{{ $contract->start_fee_payment_date }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="start-fee-total-amount" class="col col-sm-4 col-form-label text-md-end">{{ __('支払金額') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control start-fee-total-amount" name="startFeeTotalAmount" value="{{ $contract->start_fee_total_amount }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm">
                                <div class="row justify-content-start">
                                    <label for="start-fee-payment-comment" class="col col-sm-4 col-form-label text-md-end">{{ __('備考※') }}</label>
                                    <div class="col-sm-8">
                                        <textarea class="input-sm form-control start-fee-payment-comment" name="startFeePaymentComment" value="{{ $contract->start_fee_payment_comment }}" row="2" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-amount" class="col col-sm-4 col-form-label text-md-end">{{ __('成功金') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control success-fee-payment-amount" name="successFeePaymentAmount" value="{{ $contract->success_fee_payment_amount }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-method" class="col col-sm-4 col-form-label text-md-end">{{ __('支払い方法') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select success-fee-payment-method" aria-label=".form-select success-fee-payment-method" name="successFeePaymentMethod" disabled>
                                            <option value="">選択して下さい</option>
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}" {{ $payment_method->id == $contract->success_fee_payment_method_id ? "selected" : "" }}>
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
                                        <input type="date" class="input-sm form-control success-fee-payment-date" name="successFeePaymentDate" value="{{ $contract->success_fee_payment_date }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="success-fee-total-amount" class="col col-sm-4 col-form-label text-md-end">{{ __('支払金額') }}</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="input-sm form-control success-fee-total-amount" name="successFeeTotalAmount" value="{{ $contract->success_fee_total_amount }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <div class="row justify-content-start">
                                    <label for="success-fee-payment-comment" class="col col-sm-4 col-form-label text-md-end">{{ __('備考※') }}</label>
                                    <div class="col-sm-8">
                                        <textarea class="input-sm form-control success-fee-payment-comment" name="successFeePaymentComment" value="{{ $contract->success_fee_payment_comment }}" row="2" disabled></textarea>
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
                                        <input type="text" class="input-sm form-control application-number" name="applicationNumber" value="{{ $contract->application_number }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-date" class="col col-sm-4 col-form-label text-md-end">{{ __('申請日') }}</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="input-sm form-control application-date" name="applicationDate" value="{{ $contract->application_date }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-document" class="col col-sm-4 col-form-label text-md-end">{{ __('申請書類') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control application-document" name="applicationDocumente" value="{{ $contract->application_document }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="additional-document" class="col col-sm-4 col-form-label text-md-end">{{ __('追加資料') }}</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="input-sm form-control additional-document" name="additionalDocument" value="{{ $contract->additional_document }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3">
                                <div class="row justify-content-start">
                                    <label for="application-status" class="col col-sm-4 col-form-label text-md-end">{{ __('申請結果') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select application-status" name="applicationStatus" disabled>
                                            <option value="">選択して下さい</option>
                                            @foreach($application_statuses as $application_status)
                                                <option value="{{ $application_status->id }}" {{ $application_status->id == $contract->application_status_id ? "selected" : "" }}>
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
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7"></div>
            <div class="col-sm-5 pt-2 btn-group">
                <div class='btn-toolbar' role="toolbar">
                    <button type="button" class="btn btn-outline-primary btn-sm text-nowrap mr-1" id="contractEditButton">契約情報修正</button>
                    <div class="btn-group btn-update-cancel" role="group">
                        <button type="submit" formaction="{{ route('contract.update') }}" class="btn btn-outline-success btn-sm text-nowrap" id="contractUpdateButton">契約情報更新</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm text-nowrap" id="contractCancelButton">キャンセル</button>
                    </div>
                    <button type="submit" formaction="{{ route('contract.delete') }}" class="btn btn-outline-danger btn-sm text-nowrap" id="contractDelButton">契約情報削除</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="contractId" value={{ $contract->id }}>
    </form>
</div>

<script>
$(document).ready(function() {
    $(".btn-update-cancel").hide();
});

$(document).on("click", "#contractEditButton", function () {
    $("#contractEditButton").hide();
    $("#contractDelButton").hide();
    $(".btn-update-cancel").show();

    $(".management-number").attr("disabled", false);
    $(".reception-date").attr("disabled", false);
    $(".receptionist").attr("disabled", false);
    $(".contract-type").attr("disabled", false);
    $(".residence-type").attr("disabled", false);
    $(".start-fee-payment-amount").attr("disabled", false);
    $(".start-fee-payment-method").attr("disabled", false);
    $(".start-fee-payment-date").attr("disabled", false);
    $(".start-fee-total-amount").attr("disabled", false);
    $(".start-fee-payment-comment").attr("disabled", false);
    $(".success-fee-payment-amount").attr("disabled", false);
    $(".success-fee-payment-method").attr("disabled", false);
    $(".success-fee-payment-date").attr("disabled", false);
    $(".success-fee-total-amount").attr("disabled", false);
    $(".success-fee-payment-comment").attr("disabled", false);
    $(".application-number").attr("disabled", false);
    $(".application-date").attr("disabled", false);
    $(".application-document").attr("disabled", false);
    $(".additional-document").attr("disabled", false);
    $(".application-status").attr("disabled", false);
});

$(document).on("click", "#contractCancelButton", function () {
    // 未保存内容ある場合、残されるままになるため、reloadさせる
    if (confirm("修正をキャンセルします。よろしいですか？")) {
        location.reload();
    }
});

$(document).on("click", "#contractUpdateButton", function () {
    return confirm("更新処理を行います。よろしいですか？");
});

$(document).on("click", "#contractDelButton", function () {
    return confirm("削除処理を行います。よろしいですか？");
});

@if (session('message'))
    $(function () {
        toastr.success('{{ session('message') }}');
    });
@endif
</script>

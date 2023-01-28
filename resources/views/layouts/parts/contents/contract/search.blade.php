<div class="row pt-md-2" id="searchCondition">
    <div class="col-md-10 pt-md-3">
        <div class="row">
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">受付担当者</span>
                    </div>
                    <select class="form-select form-select search-receptionist" aria-label=".form-select receptionist" id="searchReceptionist" {{ Auth::user()->role_id == 2 ? "disabled" : "" }}>
                        <option value="" class="text-center">>>> 選択 <<<</option>
                        @foreach($users as $user)
                            <option class="text-center" value="{{ $user->id }}" {{ Auth::user()->role_id == 2 ? "selected" : "" }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">受付年月日</span>
                    </div>
                    <input type="date" class="input-sm form-control reception_date" id="searchReceptionDate">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">契約種類</span>
                    </div>
                    <select class="form-select form-select search-contract-type" aria-label=".form-select search-contract-type" id="searchContractType">
                        <option value="" class="text-center">>>> 選択 <<<</option>
                        @foreach($contract_types as $contract_type)
                            <option class="text-center" value="{{ $contract_type->id }}">
                                {{ $contract_type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">申請日</span>
                    </div>
                    <input type="date" class="input-sm form-control application_date" id="searchApplicationDate">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">着手金支払日</span>
                    </div>
                    <input type="date" class="input-sm form-control start_fee_payment_date" id="searchStartFeePaymentDate">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">成功金支払日</span>
                    </div>
                    <input type="date" class="input-sm form-control success_fee_payment_date" id="searchSuccessFeePaymentDate">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">申請内容</span>
                    </div>
                    <select class="form-select form-select search-application-residence-type" aria-label=".form-select search-application-residence-type" id="searchApplicationResidenceType">
                        <option value="" class="text-center">>>> 選択 <<<</option>
                        @foreach($application_residence_types as $application_residence_type)
                            <option class="text-center" value="{{ $application_residence_type->id }}">
                                {{ $application_residence_type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">申請結果</span>
                    </div>
                    <select class="form-select form-select search-application-status" aria-label=".form-select search-application-status" id="searchApplicationStatus">
                        <option value="" class="text-center">>>> 選択 <<<</option>
                        @foreach($application_statuses as $application_status)
                            <option class="text-center" value="{{ $application_status->id }}">
                                {{ $application_status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">内容検索</span>
                    </div>
                    <input type="text" class="form-control" id="searchWildcardContent" placeholder="お客様名前、電話番号、会社名、関連人員、管理番号、申請番号">
                </div>
            </div>
        </div>
        <div class="row p-0 m-0">
            <p class="align-text-top p-0 m-0">合計件数: <span class="align-text-top  p-0 m-0" id="searchTotal">{{ $contracts->total() }}</span></p>
        </div>
    </div>
    <div class="col-md-2 pt-md-3 align-self-end text-right">
        <button type="button" class="btn btn-outline-primary contract-search-btn text-nowrap" id="contractSearchButton">案件検索</button>
    </div>
</div>
<hr>
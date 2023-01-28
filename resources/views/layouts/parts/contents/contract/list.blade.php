<div class="table-responsive" style="height: 798px;">
    <div class="row p-0 m-0" id="contractSearchResult">
        <div class="col">
            <div class="row p-0 m-0">
                <div class="col">
                    <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                        <thead>
                            <tr class="fixed-header">
                                <th scope="col">#</th>
                                <th scope="col">案件登録日時</th>
                                <th scope="col">案件管理番号</th>
                                <th scope="col">お客様名前</th>
                                <th scope="col">お客様電話番号</th>
                                <th scope="col">現在の在留資格</th>
                                <th scope="col">契約種類</th>
                                <th scope="col">申請内容</th>
                                <th scope="col">申請番号</th>
                                <th scope="col">申請日</th>
                                <th scope="col">申請結果</th>
                                <th scope="col">受付担当者</th>
                                <th scope="col">受付年月日</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rowIndex = 1; ?>
                            @foreach($contracts as $contract)
                                <tr data-type-id={{ $contract->id }}>
                                    <th scope="row">{{ $rowIndex }}</th>
                                    <td>{{ $contract->created_at }}</td>
                                    <td>
                                        <a href="/contract/detail/{{ $contract->id }}" class="link-info" target="_blank" rel="noopener noreferrer">{{ $contract->management_number }}</a>
                                    </td>
                                    <td>
                                        <a href="/member/detail/{{ $contract->member_id }}" class="link-info" target="_blank" rel="noopener noreferrer">{{ $contract->member_name }}</a>
                                    </td>
                                    <td>{{ $contract->tel }}</td>
                                    <td>{{ $contract->current_residence_type_name }}</td>
                                    <td>{{ $contract->contract_name }}</td>
                                    <td>{{ $contract->application_residence_name }}</td>
                                    <td>{{ $contract->application_number }}</td>
                                    <td>{{ $contract->application_date }}</td>
                                    <td>{{ $contract->application_status }}</td>
                                    <td>{{ $contract->receptionist }}</td>
                                    <td>{{ $contract->reception_date }}</td>
                                    <?php $rowIndex++; ?>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pt-3 d-flex justify-content-center">
                        {{ $contracts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
@if (session('message'))
    $(function () {
        toastr.success('{{ session('message') }}');
    });
@endif

$("#contractSearchButton").click(function () {
    var searchReceptionist = $("#searchReceptionist").val() ? $("#searchReceptionist").val() : null;
    var searchReceptionDate = $("#searchReceptionDate").val() ? $("#searchReceptionDate").val() : null;
    var searchContractType = $("#searchContractType").val() ? $("#searchContractType").val() : null;
    var searchApplicationResidenceType = $("#searchApplicationResidenceType").val() ? $("#searchApplicationResidenceType").val() : null;
    var searchStartFeePaymentDate = $("#searchStartFeePaymentDate").val() ? $("#searchStartFeePaymentDate").val() : null;
    var searchSuccessFeePaymentDate = $("#searchSuccessFeePaymentDate").val() ? $("#searchSuccessFeePaymentDate").val() : null;
    var searchWildcardContentOrigin = ($("#searchWildcardContent").val()).replace(/\s+/g,'');
    var searchWildcardContent = searchWildcardContentOrigin ? searchWildcardContentOrigin : null;
    var searchApplicationDate = $("#searchApplicationDate").val() ? $("#searchApplicationDate").val() : null;
    var searchApplicationStatus = $("#searchApplicationStatus").val() ? $("#searchApplicationStatus").val() : null;
    // var searchMemberName = $("#searchMemberName").val() ? $("#searchMemberName").val() : null;
    // var searchMemberTelephoneNumber = $("#searchMemberTelephoneNumber").val() ? $("#searchMemberTelephoneNumber").val() : null;
    // var searchMemberCompany = $("#searchMemberCompany").val() ? $("#searchMemberCompany").val() : null;
    // var searchMemberelatedPersonnel = $("#searchMemberelatedPersonnel").val() ? $("#searchMemberelatedPersonnel").val() : null;
    // var searchManagementNumber = $("#searchManagementNumber").val() ? $("#searchManagementNumber").val() : null;
    // var searchApplicatioNumber = $("#searchApplicatioNumber").val() ? $("#searchApplicatioNumber").val() : null;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        type: "POST",
        url: "/contract/search",
        dataType: "json",
        data: {
            searchReceptionist: searchReceptionist,
            searchReceptionDate: searchReceptionDate,
            searchContractType: searchContractType,
            searchApplicationResidenceType: searchApplicationResidenceType,
            searchStartFeePaymentDate: searchStartFeePaymentDate,
            searchSuccessFeePaymentDate: searchSuccessFeePaymentDate,
            searchWildcardContent: searchWildcardContent,
            searchApplicationDate: searchApplicationDate,
            searchApplicationStatus: searchApplicationStatus,
            // searchMemberName: searchMemberName,
            // searchMemberTelephoneNumber: searchMemberTelephoneNumber,
            // searchMemberCompany: searchMemberCompany,
            // searchMemberelatedPersonnel: searchMemberelatedPersonnel,
            // searchManagementNumber: searchManagementNumber,
            // searchApplicatioNumber: searchApplicatioNumber,
        },
    }).done(function(res){
        $("#contractSearchResult").html(res['html']);
        $("#searchTotal").text(res['total']);
        // console.log(res);
    }).fail(function(XMLHttpRequest, textStatus, error){
        console.log(error.statusText);
    });
});

// 非同期処理のページング処理(現在の検索条件を設定)
$(document).ready(function() {
    $(document).on('click', '.pagination a', function (e) {
        var url = $(this).attr('href');
        // 検索の場合のみ、非同期処理させる
        if (url.includes("search?")) {
            var page = url.split('page=')[1];
            getPosts(url, page);
            e.preventDefault();
        }
    });
});

function getPosts(url, page) {
    $.ajax({
        url : url,
        dataType: 'json',
    }).done(function (data) {
        $('#contractSearchResult').html(data['html']);
    }).fail(function () {
        alert('Posts could not be loaded.');
    });
}
</script>

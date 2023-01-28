<p class="mb-0 font-weight-bold display-8"><i class="fa-solid fa-users fa-lg pr-1"></i>签约案件人数月别</p>
<p class="mb-0 display-8">申請内容: <span class="align-text-top p-0 m-0" id="residenceType">{{ $application_residence_type_name }}</span></p>
<div class="container-fluid p-0 pb-3 m-0 contract-by-type-quantity-summary-container" id="contractByTypeQuantitySummaryContainer">
    <div class="row p-0 m-0">
        <div class="col">
            <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                <thead>
                    @foreach($member_summary_by_contract_type_by_month as $date => $contract_type_detail)
                        @if ($date == $summary_year . "-01")
                            <tr class="fixed-header">
                                <th scope="col">人数</th>
                                @foreach($contract_type_detail["contract"] as $contract_type_name => $info)
                                    <th scope="col">{{ $contract_type_name }}</td>
                                @endforeach
                                <th scope="col" class="bg-success">合計</td>
                                <th scope="col" class="bg-success">当月占比(%)</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">{{ $date }}</th>
                                @foreach($contract_type_detail["contract"] as $contract_type_name => $info)
                                    <td>{{ $info["memberTotal"] }}</td>
                                @endforeach
                                <td class="fw-bold">{{ $contract_type_detail["totalMemberPerMonth"] }}</td>
                                <td class="text-danger">{{ $contract_type_detail["memberPercentByYear"] }}%</td>
                            </tr>
                        @else
                            <tr>
                                <th scope="row">{{ $date }}</th>
                                @foreach($contract_type_detail["contract"] as $contract_type_name => $info)
                                    <td>{{ $info["memberTotal"] }}</td>
                                @endforeach
                                <td class="fw-bold">{{ $contract_type_detail["totalMemberPerMonth"] }}</td>
                                <td class="text-danger">{{ $contract_type_detail["memberPercentByYear"] }}%</td>
                            </tr>
                        @endif 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
<p class="mb-0 font-weight-bold display-8"><i class="fa-solid fa-comment-dollar fa-lg pr-1"></i>签约案件金额月别</p>
<p class="mb-0 display-8">申請内容: <span class="align-text-top p-0 m-0" id="residenceType">{{ $application_residence_type_name }}</span></p>
<div class="container-fluid p-0 pb-3 m-0 contract-by-type-quantity-summary-container" id="contractByTypeIncomeSummaryContainer">
    <div class="row p-0 m-0">
        <div class="col">
            <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                <thead>
                    @foreach($income_summary_by_contract_type_by_month as $date => $contract_type_detail)
                        @if ($date == $summary_year . "-01")
                            <tr class="fixed-header">
                                <th scope="col">案件金額</th>
                                @foreach($contract_type_detail["contract"] as $contract_type_name => $info)
                                    <th scope="col">{{ $contract_type_name }}</td>
                                @endforeach
                                <th scope="col" class="bg-success">合計</td>
                                <th scope="col" class="bg-success">当月占比(%)</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">{{ $date }}</th>
                                @foreach($contract_type_detail["contract"] as $contract_type_name => $info)
                                    <td>{{ number_format($info["startFeePaymentTotal"] + $info["successFeePaymentTotal"]) }}</td>
                                @endforeach
                                <td class="fw-bold">{{ number_format($contract_type_detail["totalIncomePerMonth"]) }}</td>
                                <td class="text-danger">{{ $contract_type_detail["incomePercentByYear"] }}%</td>
                            </tr>
                        @else
                            <tr>
                                <th scope="row">{{ $date }}</th>
                                @foreach($contract_type_detail["contract"] as $contract_type_name => $info)
                                    <td>{{ number_format($info["startFeePaymentTotal"] + $info["successFeePaymentTotal"]) }}</td>
                                @endforeach
                                <td class="fw-bold">{{ number_format($contract_type_detail["totalIncomePerMonth"]) }}</td>
                                <td class="text-danger">{{ $contract_type_detail["incomePercentByYear"] }}%</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
<p class="mb-0 font-weight-bold display-8"><i class="fa-solid fa-file-contract fa-lg pr-1"></i>签约案件数量年统计</p>
<p class="mb-0 display-8">申請内容: <span class="align-text-top p-0 m-0" id="residenceType">{{ $application_residence_type_name }}</span></p>
<div class="container-fluid p-0 pb-3 m-0 contract-by-type-quantity-summary-container" id="contractByTypeQuantitySummaryByYearContainer">
    <div class="row" id="contractByTypeQuantitySummaryByYearRow">
        <div class="col">
            <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                <thead>
                    <tr class="fixed-header">
                        <th scope="col">案件数量</th>
                        @foreach($contract_summary_by_contract_type_by_year["contract"] as $contract_type_name => $info)
                            <th scope="col">{{ $contract_type_name }}</td>
                        @endforeach
                        <th scope="col" class="bg-success">合計</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">件数</th>
                        @foreach($contract_summary_by_contract_type_by_year["contract"] as $info)
                            <td>{{ $info["contractTotal"] }}</td>
                        @endforeach
                        <td class="fw-bold">{{ $contract_summary_by_contract_type_by_year["contractTotal"] }}</td>
                    </tr>
                    <tr>
                        <th scope="row">年度占比(%)</th>
                        @foreach($contract_summary_by_contract_type_by_year["contract"] as $info)
                            <td class="text-danger">{{ $info["contractPercentByYear"] }}%</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-sm-6 text-center">
            <canvas id="contractTypeNumBarChart">
                Canvas not supported...
            </canvas>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-5 align-content-center">
            <canvas id="contractTypeNumPieChart">
                Canvas not supported...
            </canvas>
        </div>
    </div>
</div>
<hr>
<p class="mb-0 font-weight-bold display-8"><i class="fa-solid fa-comment-dollar fa-lg pr-1"></i>签约案件金额年统计</p>
<p class="mb-0 display-8">申請内容: <span class="align-text-top p-0 m-0" id="residenceType">{{ $application_residence_type_name }}</span></p>
<div class="container-fluid p-0 pb-3 m-0 contract-by-type-amount-summary-container" id="contractByTypeAmountSummaryContainer">
    <div class="row" id="contractByTypeQuantitySummaryByYearRow">
        <div class="col">
            <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                <thead>
                    <tr class="fixed-header">
                        <th scope="col">案件金額</th>
                        @foreach($income_summary_by_contract_type_by_year["contract"] as $contract_type_name => $info)
                            <th scope="col">{{ $contract_type_name }}</td>
                        @endforeach
                        <th scope="col" class="bg-success">合計</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">収入</th>
                        @foreach($income_summary_by_contract_type_by_year["contract"] as $info)
                            <td>{{ number_format($info["startFeePaymentTotalByYear"] + $info["successFeePaymentTotalByYear"]) }}</td>
                        @endforeach
                        <td class="fw-bold">{{ number_format($income_summary_by_contract_type_by_year["incomeTotal"]) }}</td>
                    </tr>
                    <tr>
                        <th scope="row">年度占比(%)</th>
                        @foreach($income_summary_by_contract_type_by_year["contract"] as $info)
                            <td class="text-danger">{{ $info["incomePercentByYear"] }}%</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-sm-6 text-center">
            <canvas id="contractTypeIncomeBarChart">
                Canvas not supported...
            </canvas>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-5 align-content-center">
            <canvas id="contractTypeIncomePieChart">
                Canvas not supported...
            </canvas>
        </div>
    </div>
</div>
<hr>
<p class="mb-0 font-weight-bold display-8"><i class="fa-solid fa-comment-dollar fa-lg pr-1"></i>签约案件数量月别</p>
<div class="row pb-3" id="contractByResidenceTypeSummaryContainer">
    <div class="col">
        <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
            <thead>
                <?php $i = 0; ?>
                @foreach($contract_count_summary_by_residence_type_by_month as $residence_type => $info)
                    @if ($i < 1)
                        <tr class="fixed-header">
                            <th scope="col">案件件数</th>
                            @foreach($info["date"] as $date => $detail)
                                <th scope="col">{{ $date }}</td>
                            @endforeach
                            <th scope="col" class="bg-success">合計</td>
                            <th scope="col" class="bg-success">年度占比(%)</td>
                        </tr>
                    @endif
                    <?php $i++; ?>
                @endforeach
            </thead>
            <tbody>
                @foreach($contract_count_summary_by_residence_type_by_month as $residence_type => $info)
                    <tr>
                        <th scope="row">{{ $residence_type }}</th>
                        @foreach($info["date"] as $date => $detail)
                            <td>{{ number_format($detail["contractTotal"]) }}</td>
                        @endforeach
                        <td class="fw-bold">{{ $info["contractQuantityByYear"] }}</td>
                        <td class="text-danger">{{ $info["contractPercentByYear"] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<hr>
@if (Auth::user()->role_id == 1)
    <p class="mb-0 pb-2 font-weight-bold display-8"><i class="fa-solid fa-person-circle-exclamation fa-lg pr-1"></i>受付担当案件数量＆金额月别(管理者権限)</p>
    <div class="row" id="contractByReceptionistSummaryContainer">
        <div class="col">
            <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                <thead>
                    <?php $i = 0; ?>
                    @foreach($contract_summary_by_receptionist_by_month as $receptionist => $info)
                        @if ($i < 1)
                            <tr class="fixed-header">
                                <th scope="col">月份</th>
                                @foreach($info["date"] as $date => $detail)
                                    <th scope="col" colspan="2">{{ $date }}</td>
                                @endforeach
                                <th scope="col" colspan="2" class="bg-success">年统计</th>
                            </tr>
                            <tr class="fixed-header">
                                <th scope="col">受付担当</th>
                                @foreach($info["date"] as $date => $detail)
                                    <th scope="col">案件件数</td>
                                    <th scope="col">案件金額</td>
                                @endforeach
                                <th scope="col" class="bg-success">案件総件数</td>
                                <th scope="col" class="bg-success">案件総金額</td>
                            </tr>
                        @endif
                        <?php $i++; ?>
                    @endforeach
                </thead>
                <tbody>
                    @foreach($contract_summary_by_receptionist_by_month as $receptionist => $info)
                        <tr>
                            <th scope="row">{{ $receptionist }}</th>
                            @foreach($info["date"] as $date => $detail)
                                <td>{{ number_format($detail["contractTotal"]) }}</td>
                                <td>{{ number_format($detail["startFeePaymentTotal"] + $detail["successFeePaymentTotal"]) }}</td>
                            @endforeach
                            <td class="fw-bold">{{ number_format($info["contractTotalByYear"]) }}</td>
                            <td class="fw-bold">{{ number_format($info["startFeePaymentTotalByYear"] + $info["successFeePaymentTotalByYear"])}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
<script>
    if(contextNumChart) {
        contextNumChart.destroy(); //すでにグラフが存在すれば消す
    }

    if(contextNumPerChart) {
        contextNumPerChart.destroy(); //すでにグラフが存在すれば消す
    }

    var labelsContractNumByType = new Array();
    var labelsContractNumPerByType = new Array();
    var labelsContractIncomeByType = new Array();
    var labelsContractIncomePerByType = new Array();

    var contractNumByType = new Array();
    var contractNumPerByType = new Array();
    var contractIncomeByType = new Array();
    var contractIncomePerByType = new Array();
    var contractSummaryByContractTypeByYear = <?php echo json_encode($contract_summary_by_contract_type_by_year["contract"]); ?>;
    var incomeSummaryByContractTypeByYear = <?php echo json_encode($income_summary_by_contract_type_by_year["contract"]); ?>;

    for ( contractType in contractSummaryByContractTypeByYear) {
        labelsContractNumByType.push(contractType);
        labelsContractNumPerByType.push(contractType);

        contractNumByType.push(contractSummaryByContractTypeByYear[contractType]["contractTotal"]);
        contractNumPerByType.push(contractSummaryByContractTypeByYear[contractType]["contractPercentByYear"]);
    }

    for ( contractType in incomeSummaryByContractTypeByYear) {
        labelsContractIncomeByType.push(contractType);
        labelsContractIncomePerByType.push(contractType);

        contractIncomeByType.push(incomeSummaryByContractTypeByYear[contractType]["incomeTotalByYear"]);
        contractIncomePerByType.push(incomeSummaryByContractTypeByYear[contractType]["incomePercentByYear"]);
    }

    contextNum = document.querySelector("#contractTypeNumBarChart").getContext('2d');
    contextNumChart = new Chart(contextNum, {
        type: 'bar',
        data: {
            labels: labelsContractNumByType,
            datasets: [{
                label: "不同签约内容的数量",
                data: contractNumByType,
                backgroundColor: '#178b8f',
            }],
        },
        options: {
        responsive: true
        }
    });

    contextNumPer = document.querySelector("#contractTypeNumPieChart").getContext('2d');
    contextNumPerChart = new Chart(contextNumPer, {
        type: 'pie',
        data: {
            labels: labelsContractNumPerByType,
            datasets: [{
                label: "不同签约内容的数量%",
                data: contractNumPerByType,
                backgroundColor: '#b0305f',
            }],
        },
        options: {
        responsive: false
        }
    });

    contextIncome = document.querySelector("#contractTypeIncomeBarChart").getContext('2d');
    contextIncomeChart = new Chart(contextIncome, {
        type: 'bar',
        data: {
            labels: labelsContractIncomeByType,
            datasets: [{
                label: "不同签约内容的金額",
                data: contractIncomeByType,
                backgroundColor: '#178b8f',
            }],
        },
        options: {
        responsive: true
        }
    });

    contextIncomePer = document.querySelector("#contractTypeIncomePieChart").getContext('2d');
    contextIncomePerChart = new Chart(contextIncomePer, {
        type: 'pie',
        data: {
            labels: labelsContractIncomePerByType,
            datasets: [{
                label: "不同签约内容的金額%",
                data: contractIncomePerByType,
                backgroundColor: '#b0305f',
            }],
        },
        options: {
        responsive: false
        }
    });
</script>
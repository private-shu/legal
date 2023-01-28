<div class="container-fluid overflow-auto" style="height: 980px;">
    <div class="row justify-content-end pt-3">
        <div class="col-sm-2 text-left">
            <label for="summary-year">集計年度</label>
            <select class="form-select form-select-sm summary-year" aria-label=".form-select-sm year" id="summaryYear">
                @for ($i = 0; $i < 50; $i++)
                    <option value= {{ (2020 + $i) }} {{ (2020 + $i) == date("Y") ? "selected" : "" }} class="text-center">{{ 2020 + $i }}年</option>
                @endfor
            </select>
        </div>
        <div class="col-sm-2 text-left">
            <label for="receptionist">受付担当者</label>
            <select class="form-select form-select-sm receptionist" aria-label=".form-select-sm receptionist" {{ Auth::user()->role_id == 2 ? "disabled" : "" }} id="receptionist">
                <option value="" class="text-center">全て</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ Auth::user()->role_id == 2 ? "selected" : "" }} class="text-center">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 text-left">
            <label for="receptionist">申請内容</label>
            <select class="form-select form-select-sm application-residence-type" aria-label=".form-select-sm application-residence-type" id="applicationResidenceType">
                <option value="" class="text-center">全て</option>
                @foreach($application_residence_types as $application_residence_type)
                    <option value="{{ $application_residence_type->id }}" class="text-center">
                        {{ $application_residence_type->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="row pb-4" id="summaryDetail">
    </div>
</div>

<script>
    var contextNumChart; //グローバル変数にする
    var contextNumPerChart;

    $(document).ready(() => {
        getSummaryByYear();
    });

    $(".summary-year").change(function () {
        getSummaryByYear();
    });

    $(".receptionist").change(function () {
        getSummaryByYear();
    });

    $(".application-residence-type").change(function () {
        getSummaryByYear();
    });
 
    function getSummaryByYear() {
        var summaryYear = $("#summaryYear").val() ? $("#summaryYear").val() : null;
        var receptionist = $("#receptionist").val() ? $("#receptionist").val() : null;
        var applicationResidenceType = $("#applicationResidenceType").val() ? $("#applicationResidenceType").val() : null;

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: "/contract/getSummaryByYear",
            dataType: "json",
            data: {
                summaryYear: summaryYear,
                receptionist: receptionist,
                applicationResidenceType: applicationResidenceType
            },
        }).done(function(res){
            $("#summaryDetail").html(res['html'])
            console.log(res);
        }).fail(function(XMLHttpRequest, textStatus, error){
            console.log(error.statusText);
        });
    };
</script>
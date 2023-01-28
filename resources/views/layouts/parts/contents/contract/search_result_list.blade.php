<div class="col">
    <div class="row p-0 m-0">
        <div class="col">
            <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                <thead>
                    <tr class="fixed-header">
                        <th scope="col">#</th>
                        <th scope="col">案件登録日時</th>
                        <th scope="col">案件管理番号</th>
                        <th scope="col">名前</th>
                        <th scope="col">電話番号</th>
                        <th scope="col">在留資格</th>
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
                                <a href="/contract/detail/{{ $contract->id }}" class="link-info">{{ $contract->management_number }}</a>
                            </td>
                            <td>
                                <a href="/member/detail/{{ $contract->member_id }}" class="link-info">{{ $contract->member_name }}</a>
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
                {{-- {{ $contracts->appends(request()->query())->links() }} --}}
                {{ $contracts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
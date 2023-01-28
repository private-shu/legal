<div class="table-responsive" style="height: 798px;">
    <div class="row pt-3" id="contractSearchResult">
        <div class="col">
            <div class="row p-0 m-0">
                <div class="col">
                    <table class="table-wrapper table-hover text-nowrap" style="width: 100%;" id="contractList">
                        <thead>
                            <tr class="fixed-header">
                                <th scope="col">#</th>
                                <th scope="col">ユーザー名</th>
                                <th scope="col">メールアドレス</th>
                                <th scope="col">権限</th>
                                <th scope="col">作成日時</th>
                                <th scope="col">更新日時</th>
                                <th scope="col">削除日時(登録不可)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rowIndex = 1; ?>
                            @foreach($users as $user)
                                <tr data-type-id={{ $user->id }}>
                                    <th scope="row">{{ $rowIndex }}</th>
                                    <td>
                                        <a href="/user/detail/{{ $user->id }}" class="link-info">{{ $user->name }}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role_name }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>{{ $user->deleted_at }}</td>
                                    <?php $rowIndex++; ?>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pt-3 d-flex justify-content-center">
                        {{ $users->links() }}
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
</script>

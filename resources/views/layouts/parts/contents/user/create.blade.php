<div class="container pt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('アカウント作成') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="user-name" class="col col-sm-4 col-form-label text-md-end required">{{ __('アカウント名') }}</label>
                            <div class="col-md-6">
                                <input id="userName" type="text" class="form-control user-name" name="userName" value="{{ old('userName') }}" required autofocus>
                                @if ($errors->has('userName'))
                                    <li class="text-danger">{{$errors->first('userName')}}</li>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user-email" class="col col-sm-4 col-form-label text-md-end required">{{ __('メールアドレス') }}</label>
                            <div class="col-md-6">
                                <input id="userEmail" type="email" class="form-control user-email" name="userEmail" value="{{ old('userEmail') }}" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user-password" class="col col-sm-4 col-form-label text-md-end required">{{ __('パスワード') }}</label>
                            <div class="col-md-6">
                                <input id="userPassword" type="password" class="form-control user-password" name="userPassword" required autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="user-role" class="col col-sm-4 col-form-label text-md-end required">{{ __('権限') }}</label>
                            <div class="col-md-6">
                                <input type="hidden" name="newCreateroleType" id="newCreateroleType" value="2" />
                                <select class="form-select form-select user-role" aria-label=".form-select user-role" name="userRole" required disabled>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $role->id == 2 ? "selected" : "" }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10"></div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('作成') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
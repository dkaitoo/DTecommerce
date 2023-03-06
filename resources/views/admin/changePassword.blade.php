@extends('admin.layouts.app')

@section('content')
    <div class="main-panel" id="main-panel">
        <div class="panel-header panel-header-sm">
        </div>

        <div class="content">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <h3 class="card-header">Thay đổi mật khẩu</h3>

                            <form action="{{ route('changePwdAdminEdit') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    @include('flash-message')
                                    <div class="mb-3">
                                        <label for="oldPasswordInput" class="form-label">Mật khẩu cũ</label>
                                        <input name="old_password" type="password"
                                               class="form-control @error('old_password') is-invalid @enderror"
                                               id="oldPasswordInput"
                                               placeholder="Nhập mật khẩu cũ">
                                        @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="newPasswordInput" class="form-label">Mật khẩu mới</label>
                                        <input name="new_password" type="password"
                                               class="form-control @error('new_password') is-invalid @enderror"
                                               id="newPasswordInput"
                                               placeholder="Nhập mật khẩu mới">
                                        @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmNewPasswordInput" class="form-label">Xác nhận lại mật khẩu
                                            mới</label>
                                        <input name="new_password_confirmation" type="password" class="form-control"
                                               id="confirmNewPasswordInput"
                                               placeholder="Nhập xác nhận lại mật khẩu mới">
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-success">Lưu</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

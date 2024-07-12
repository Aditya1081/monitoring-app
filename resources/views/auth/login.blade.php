@extends('login_layout')

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0 justify-content-center">
                <div class="col-lg-4 col-sm-10">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo d-flex justify-content-center">
                            <img src="{{ asset('assets/images/Logo_Al-Azhar.png') }}" alt="logo">
                        </div>
                        <div class="text-center">
                            <h4>Halo! Mari kita mulai</h4>
                            <h6 class="font-weight-light">Masuk untuk melanjutkan.</h6>
                        </div>
                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}" required autofocus
                                    placeholder="Nama Pengguna">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    id="password" name="password" required placeholder="Kata Sandi">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit"
                                    class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">Masuk</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        Tetap masuk
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                <a href="#" class="auth-link text-black">Lupa kata sandi?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

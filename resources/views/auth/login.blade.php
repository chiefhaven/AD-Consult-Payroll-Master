@extends('adminlte::auth.login')

@push('css')
<style type="text/css">

    .card {
        border-radius: 0px !important;
    }
    .card-title {
        font-weight: 600;
    }

    .login-box{
        background: #09579B;
    }

    .login-logo a, .register-logo a {
        color: #ffffff !important;
        font-size: 2.0rem !important;
        margin-top: .9rem !important;
    }

    .card-primary.card-outline {
        border-top: none !important;
    }
</style>
@endpush

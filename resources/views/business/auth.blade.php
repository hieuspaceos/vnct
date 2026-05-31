{{-- resources/views/business/auth.blade.php --}}
@extends('index')

@push('css')
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
        }
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 30px;
            background: transparent;
            gap: 10px;
            display: flex;
            align-items: center;
        }
        .nav-tabs .nav-link.active {
            color: var(--main-red);
            border-bottom: 3px solid var(--main-red);
            background: transparent;
            
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
        }
        .btn-primary {
            background: var(--main-red);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            gap: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-primary:hover {
            background: #003299;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }
        .error-feedback {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .alert {
            border-radius: 10px;
        }
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .loading .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        .tab-pane {
            padding-top: 20px;
        }
        label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }
        .required:after {
            content: " *";
            color: red;
        }
        select.form-control {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="%23333" d="M6 9L1 4h10z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 15px center;
            height: auto !important;
        }
    </style>
@endpush    
<?php

$json_file = public_path('template/files/auth_'.App::currentLocale().'.json');
//dd($json_file);
if (file_exists($json_file)) {

    $json_content = file_get_contents($json_file);

    $data_intro = json_decode($json_content, true);   
    if ($data_intro === null) {
        $data_intro = [];
    }
} else {
    $data_intro = [];
}

?>

@section('content')
    <div class="loading" id="loading">
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">{{ $data_intro["loading"]; }}</span>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs" id="authTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ $data_intro["login_title"]; }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">
                                    <i class="fas fa-user-plus me-2"></i>{{ $data_intro["register_title"]; }}
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="authTabContent">
                            {{-- ĐĂNG NHẬP --}}
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <form id="loginForm">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="required">{{ $data_intro["username_or_email"]; }}</label>
                                        <input type="text" name="username" class="form-control" required>
                                        <div class="error-feedback" id="login_username_error"></div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="required">{{ $data_intro["password"]; }}</label>
                                        <input type="password" name="password" class="form-control" required>
                                        <div class="error-feedback" id="login_password_error"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>{{ $data_intro["login_title"]; }}
                                    </button>
                                </form>
                            </div>

                            {{-- ĐĂNG KÝ --}}
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form id="registerForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["company_name"]; }}</label>
                                                <input type="text" name="company_name" class="form-control" required>
                                                <div class="error-feedback" id="company_name_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["tax_code"]; }}</label>
                                                <input type="text" name="tax_code" class="form-control" required>
                                                <div class="error-feedback" id="tax_code_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label>{{ $data_intro["website"]; }}</label>
                                                <input type="url" name="website" class="form-control" placeholder="https://example.com">
                                                <div class="error-feedback" id="website_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["industry"]; }}</label>
                                                <input type="text" name="industry" class="form-control" required>
                                                <div class="error-feedback" id="industry_error"></div>
                                                
                                                <div class="error-feedback" id="industry_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["representative_name"]; }}</label>
                                                <input type="text" name="representative_name" class="form-control" required>
                                                <div class="error-feedback" id="representative_name_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["position"]; }}</label>
                                                <input type="text" name="position" class="form-control" required>
                                                <div class="error-feedback" id="position_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["phone"]; }}</label>
                                                <input type="tel" name="phone" class="form-control" required>
                                                <div class="error-feedback" id="phone_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["contact_email"]; }}</label>
                                                <input type="email" name="email" class="form-control" required>
                                                <div class="error-feedback" id="email_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["username"]; }}</label>
                                                <input type="text" name="username" class="form-control" required>
                                                <div class="error-feedback" id="username_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["password"]; }}</label>
                                                <input type="password" name="password" class="form-control" required>
                                                <div class="error-feedback" id="password_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="required">{{ $data_intro["password_confirmation"]; }}</label>
                                                <input type="password" name="password_confirmation" class="form-control" required>
                                                <div class="error-feedback" id="password_confirmation_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label>{{ $data_intro["description"]; }}</label>
                                                <textarea name="description" rows="3" class="form-control"></textarea>
                                                <div class="error-feedback" id="description_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-user-plus me-2"></i>{{ $data_intro["register_button"]; }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function showLoading() {
            $('#loading').css('display', 'flex');
        }

        function hideLoading() {
            $('#loading').hide();
        }

        function showMessage(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            const alertDiv = $(`
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `);
            
            $('.tab-content').prepend(alertDiv);
            setTimeout(() => {
                alertDiv.alert('close');
            }, 5000);
        }

        // Xử lý đăng nhập
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            showLoading();
            
            $.ajax({
                url: "{{ route('business.login') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showMessage(response.message, 'success');
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        $('.error-feedback').empty();
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $(`#login_${key}_error`).text(value[0]);
                        });
                    } else if (xhr.responseJSON.message) {
                        showMessage(xhr.responseJSON.message, 'danger');
                    }
                },
                complete: function() {
                    hideLoading();
                }
            });
        });

        // Xử lý đăng ký
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();
            showLoading();
            
            $.ajax({
                url: "{{ route('business.register') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        showMessage(response.message, 'success');
                        $('#registerForm')[0].reset();
                        $('.error-feedback').empty();
                        // Chuyển sang tab đăng nhập
                        //$('#login-tab').tab('show');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        $('.error-feedback').empty();
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $(`#${key}_error`).text(value[0]);
                        });
                    }
                },
                complete: function() {
                    hideLoading();
                }
            });
        });

        // Bootstrap 4 tab switch
        $(document).ready(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // Clear errors khi chuyển tab
                $('.error-feedback').empty();
                $('.alert').alert('close');
            });
        });
    </script>
@endpush
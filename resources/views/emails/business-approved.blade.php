{{-- resources/views/emails/business-approved.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo duyệt tài khoản doanh nghiệp</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            display: inline-block;
            width: 130px;
        }
        .info-value {
            color: #212529;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.4);
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-size: 14px;
        }
        .warning i {
            color: #ffc107;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }
            .info-label {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }
            .info-value {
                display: block;
                margin-left: 0;
            }
        }
    </style>
</head>
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
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $data_intro['email_success_title'] ?? '🎉 Chúc mừng doanh nghiệp của bạn!' }}</h1>
        </div>

        <div class="content">
            <p>{{ $data_intro['chao_doanh_nghiep'] ?? 'Xin chào' }} <strong>{{ $business->company_name }}</strong>,</p>
            
            <p>{{ $data_intro['email_success_welcome'] ?? 'Cảm ơn bạn đã đăng ký tài khoản doanh nghiệp tại hệ thống' }} <strong>{{ $appName }}</strong>.</p>
            
            <div class="info-box">
                <div class="info-item">
                    <span class="info-label">{{ $data_intro['company_name'] ?? 'Tên doanh nghiệp' }}:</span>
                    <span class="info-value">{{ $business->company_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">{{ $data_intro['tax_code'] ?? 'Mã số thuế' }}:</span>
                    <span class="info-value">{{ $business->tax_code }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">{{ $data_intro['username'] ?? 'Tên tài khoản' }}:</span>
                    <span class="info-value">{{ $business->username }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">{{ $data_intro['email_success_login_email'] ?? 'Email đăng nhập' }}:</span>
                    <span class="info-value">{{ $business->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">{{ $data_intro['email_success_representative'] ?? 'Người đại diện' }}:</span>
                    <span class="info-value">{{ $business->representative_name }} ({{ $business->position }})</span>
                </div>
                <div class="info-item">
                    <span class="info-label">{{ $data_intro['email_success_approval_date'] ?? 'Ngày duyệt' }}:</span>
                    <span class="info-value">{{ now()->format('d/m/Y H:i:s') }}</span>
                </div>
            </div>

            <p style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">
                    {{ $data_intro['email_success_login_now'] ?? '🔐 Đăng nhập ngay' }}
                </a>
            </p>

            <div class="warning">
                <strong>{{ $data_intro['email_success_note_title'] ?? '📌 Lưu ý:' }}</strong>
                <ul style="margin: 10px 0 0 20px; padding: 0;">
                    <li>{{ $data_intro['email_success_note_1'] ?? 'Bạn có thể đăng nhập bằng tên tài khoản hoặc email' }} <strong>{{ $business->username }}</strong> hoặc <strong>{{ $business->email }}</strong></li>
                    <li>{{ $data_intro['email_success_note_2'] ?? 'Vui lòng không chia sẻ mật khẩu với bất kỳ ai' }}</li>
                    <li>{{ $data_intro['email_success_note_3'] ?? 'Nếu bạn quên mật khẩu, vui lòng liên hệ với bộ phận hỗ trợ' }}</li>
                    <li>{{ $data_intro['email_success_note_4'] ?? 'Để đảm bảo an toàn, hãy đăng xuất sau khi sử dụng trên máy tính công cộng' }}</li>
                </ul>
            </div>

            <p>{{ $data_intro['email_success_question'] ?? 'Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại hỗ trợ.' }} <strong>info@vnct.org</strong></p>
            
            <p>{{ $data_intro['email_success_wish'] ?? 'Chúc bạn có những trải nghiệm tuyệt vời cùng hệ thống của chúng tôi!' }}</p>
            
            <p>
                {{ $data_intro['tran_trong'] ?? 'Trân trọng,' }}<br>
                <strong>{{ $data_intro['doi_ngu_quan_tri'] ?? 'Đội ngũ quản trị' }} {{ $appName }}</strong>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ $year }} {{ $appName }}. {{ $data_intro['ban_quyen'] ?? 'Tất cả các quyền được bảo lưu.' }}</p>
            <p>{{ $data_intro['email_success_auto_sent'] ?? 'Email này được gửi tự động từ hệ thống, vui lòng không phản hồi lại email này.' }}</p>
        </div>
    </div>
</body>
</html>
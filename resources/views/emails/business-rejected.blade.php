{{-- resources/views/emails/business-rejected.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo từ chối đăng ký</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .reason-box {
            background: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 600;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
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
            <h1>{{ $data_intro['thong_bao_tu_choi_tieu_de'] ?? '⚠️ Thông báo từ chối đăng ký' }}</h1>
        </div>

        <div class="content">
            <p>{{ $data_intro['chao_doanh_nghiep'] ?? 'Xin chào' }} <strong>{{ $business->company_name }}</strong>,</p>
            
            <p>{{ $data_intro['cam_on_quan_tam'] ?? 'Cảm ơn bạn đã quan tâm và đăng ký tài khoản doanh nghiệp tại hệ thống' }} <strong>{{ config('app.name') }}</strong>.</p>
            
            <p>{{ $data_intro['thong_bao_tu_choi_noi_dung'] ?? 'Rất tiếc, sau khi xem xét hồ sơ đăng ký của doanh nghiệp bạn, chúng tôi quyết định TỪ CHỐI đăng ký với lý do:' }}</p>
            
            <div class="reason-box">
                <strong>{{ $data_intro['ly_do_tu_choi'] ?? '📝 Lý do từ chối:' }}</strong>
                <p style="margin-top: 10px;">{{ $reason }}</p>
            </div>

            <p>{{ $data_intro['ho_tro_thac_mac'] ?? 'Để được hỗ trợ và giải đáp thắc mắc, vui lòng liên hệ với chúng tôi qua email' }} <strong>{{ $supportEmail }}</strong>.</p>
            
            <p>{{ $data_intro['dang_ky_lai'] ?? 'Bạn có thể đăng ký lại với thông tin chính xác và đầy đủ hơn.' }}</p>
            
            <p>
                {{ $data_intro['tran_trong'] ?? 'Trân trọng,' }}<br>
                <strong>{{ $data_intro['doi_ngu_quan_tri'] ?? 'Đội ngũ quản trị' }} {{ config('app.name') }}</strong>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ $data_intro['ban_quyen'] ?? 'Tất cả các quyền được bảo lưu.' }}</p>
        </div>
    </div>
</body>
</html>
<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class CustomHandler extends ExceptionHandler
{
    public function render($request, \Throwable $exception)
    {

        // Nếu là lỗi ModelNotFound (không tìm thấy bài viết)
        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return redirect('/');
        }
        //dd($exception->getStatusCode());
        // Các lỗi 500 khác
        if ($this->isHttpException($exception) && $exception->getStatusCode() == 500) {
            return redirect('/');
        }
        
        return parent::render($request, $exception);
    }
}
?>
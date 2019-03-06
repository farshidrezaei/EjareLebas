<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Telegram\Bot\Laravel\Facades\Telegram;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     *
     * @return void
     * @throws Exception
     */
    public function report( Exception $exception )
    {
        parent::report( $exception );
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render( $request, Exception $exception )
    {
        if ( $this->isHttpException( $exception ) ) {

            if ( ! env( 'APP_DEBUG' ) ) {
                $message =
                    '```#Host: ' . config( 'app.name' ) . "\n\n" .
                    '#url: ' . url()->current() . "\n\n" .
                    '#file: ' . $exception->getFile() . "\n\n" .
                    '#Line: ' . $exception->getLine() . "\n\n" .
                    '#Message: ' . $exception->getMessage() . "\n\n```";

                Telegram::sendMessage( [
                    'chat_id' => '@tooska_error_reporter',
                    'text' => $message
                ] );
            }


            switch ( $exception->getStatusCode() ) {
                // not found
                case 404:
                    $data = [
                        'title' => 'خطای ۴۰۴ !',
                        'message' => 'صفحه ی مورد مورد نظر یافت نشد.',
                        'button_title' => 'بازگشت',
                        'button_link' => '/admin',
                    ];
                    return response()->view( 'errors.err', compact( 'data' ) );
                    break;

                // internal error
                case '500':
                    return 'internal Err';
                    break;

                default:
                    return $this->renderHttpException( $exception );
                    break;
            }
        }
            return parent::render( $request, $exception );
    }
}

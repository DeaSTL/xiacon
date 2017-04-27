<?php

namespace Core\Debug;

use Exception;
use Core\Http\View;
use Symfony\Component\Debug\ErrorHandler as SymfonyErrorHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Renders the exception message.
 */
class ExceptionRenderer
{
    public function __construct()
    {
        SymfonyErrorHandler::register();
    }

    /**
     * Renders the error.
     *
     * @param \Exception $e
     * @param bool       $debug
     *
     * @return void
     */
    public function render(Exception $e, $debug)
    {
        $e = FlattenException::create($e);
        $handler = new SymfonyExceptionHandler($debug);
        $status = $e->getStatusCode();

        $response = SymfonyResponse::create($handler->getHtml($e), $status, $e->getHeaders());

        $rex = explode("\n", $response);

        if (strstr(strtolower($rex[0]), 'http')) {
            for ($i = 0; $i < 2; $i++) {
                array_shift($rex);
            }
        }

        if (View::exists("errors.{$status}")) {
            echo View::renderView("errors.{$status}", 'exception', implode("\n", $rex));
        } else {
            echo implode("\n", $rex);
        }
    }
}

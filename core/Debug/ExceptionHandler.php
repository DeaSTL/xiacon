<?php

namespace Core\Debug;

use ErrorException;
use Exception;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;

/**
 * Handles exceptions to spit out into Symfony debug stuff.
 */
class ExceptionHandler
{
    /**
     * Class Contstructor.
     *
     * @return void
     */
    public function __construct()
    {
        error_reporting(-1);
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
        ini_set('display_errors', 'off');
    }

    /**
     * Handles exceptions.
     *
     * @param \Throwable $e
     *
     * @return void
     */
    public function handleException($e)
    {
        if (!$e instanceof Exception) {
            $e = new FatalThrowableError($e);
        }

        $this->getExceptionRenderer()->render($e, $this->debug());
    }

    /**
     * Handles errors.
     *
     * @param int    $leve
     * @param string $message
     * @param string $file
     * @param int    $line
     * @param array  $context
     *
     * @throws \ErrorException
     *
     * @return void
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handles error handling shutdown.
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (!is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException($this->fatalExceptionFromError($error, 0));
        }
    }

    /**
     * converts error into exception.
     *
     * @param array    $error
     * @param int|null $traceOffset
     *
     * @return \Symfony\Component\Debug\Exception\FatalErrorException
     */
    protected function fatalExceptionFromError(array $error, $traceOffset = null)
    {
        return new FatalErrorException($error['message'], $error['type'],
            0, $error['file'], $error['line'], $traceOffset);
    }

    /**
     * Checks if the given error is a fatal one.
     *
     * @param int $type
     *
     * @return bool
     */
    protected function isFatal($type)
    {
        return in_array($type, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    /**
     * Checks whether the app is in debug mode or not.
     *
     * @return bool
     */
    private function debug()
    {
        return env('DEBUG', false);
    }

    /**
     * Gets the exception renderer.
     *
     * @return \Scara\Debug\ExceptionRenderer
     */
    private function getExceptionRenderer()
    {
        return new ExceptionRenderer();
    }
}

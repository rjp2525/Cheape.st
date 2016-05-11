<?php

namespace Cheapest\Exceptions;

use App;
use Cheapest\Exceptions\GithubIssue;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);

        // Ensure that only live production errors get pushed
        if (getenv('APP_URL') == 'http://cheape.st' && App::environment('local', 'staging', 'production')) {
            $severity = null;
            // getSeverity doesn't exist in base exceptions
            if (method_exists($e, 'getSeverity')) {
                $severity = $e->getSeverity();
            }

            $this->createIssue(
                $e->getMessage(),
                $e->getCode(),
                $severity,
                $e->getFile(),
                $e->getLine(),
                $e->getTraceAsString()
            );
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        return parent::render($request, $e);
    }

    public static function createIssue($message = null, $code = null, $severity = null, $path = null, $lineno = null, $trace = null)
    {
        if (null === array_unique([$message, $code, $severity, $path, $lineno, $trace])) {
            throw new ErrorException('At least one parameter must be set.');
        }

        $issue = new GithubIssue($message, $code, $severity, $path, $lineno, $trace);

        return $issue->commit(
            env('GITHUB_USERNAME', 'username'),
            env('GITHUB_PASSWORD', 'password'),
            env('GITHUB_REPO_AUTHOR', 'author'),
            env('GITHUB_REPO_NAME', 'name')
        );
    }
}

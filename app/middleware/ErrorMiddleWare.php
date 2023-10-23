<?php

//namespace App\Middleware;

//
//##########################
/*
$customErrorHandler = function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
    ) use ($app) {
        if ($logger) {
            $logger->error($exception->getMessage());
        }
    
        $payload = ['error' => $exception->getMessage()];
    
        $response = $app->getResponseFactory()->createResponse();
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );
    
        return $response;
};
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
*/
//##########################
//

/*
class CustomErrorMiddleware
{
    private $app;
    public function __construct($app){
        $this->app = $app;
    }


    //public function

    //$customErrorHandler = function (
    //public function __invoke(
    public function errorHandler(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null)
        {
            if ($logger) {
                $logger->error($exception->getMessage());
            }
        
            $payload = ['error' => $exception->getMessage()];
        
            $response = $app->getResponseFactory()->createResponse();
            $response->getBody()->write(
                json_encode($payload, JSON_UNESCAPED_UNICODE)
            );
        
            return $response;
    }//;
}
*/

<?php
namespace CloudFlare;

use Psr\Http\Message\RequestInterface;
use Api\Client as ApiClient;
use Api\CommandInterface;

class Client extends ApiClient
{
    public function __construct(array $args)
    {
        if (!isset($args['modelsDir'])) {
            $args['modelsDir'] = __DIR__ . '/../data';
        }
        
        $email = $args['email'];
        $key = $args['key'];
        
        parent::__construct($args);
        
        $stack = $this->getHandlerList();
        
        $stack->appendBuild(function (callable $handler) use ($key, $email) {
            return function (
                CommandInterface $command,
                RequestInterface $request
            ) use ($handler, $key, $email) {
                $request = $request->withHeader('X-Auth-Key', $key)
                                   ->withHeader('X-Auth-Email', $email);

                return $handler($command, $request);
            };
        });
    }

    public static function _add_auth_header(callable $handler)
    {
        $key = $this->key;
        $email = $this->email;
        
        return function (
            CommandInterface $command,
            RequestInterface $request
        ) use ($handler, $key, $email) {
            $request = $request->withHeader('X-Auth-Key', $key)
                               ->withHeader('X-Auth-Email', $email);

            return $handler($command, $request);
        };
    }
}
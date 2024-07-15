<?php

namespace App\Services;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\ClientCredentialsGrant;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;

class OAuthProvider
{
    protected $server;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        ScopeRepositoryInterface $scopeRepository,
        UserRepositoryInterface $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $privateKey = new CryptKey('file://' . storage_path('oauth-private.key'), null, false);
        $encryptionKey = config('app.key');

        $this->server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        $passwordGrant = new PasswordGrant($userRepository, $refreshTokenRepository);
        $passwordGrant->setRefreshTokenTTL(new \DateInterval('P1M')); // Refresh tokens will expire after 1 month

        $this->server->enableGrantType(
            $passwordGrant,
            new \DateInterval('PT1H') // Access tokens will expire after 1 hour
        );

        $this->server->enableGrantType(
            new RefreshTokenGrant($refreshTokenRepository),
            new \DateInterval('PT1H') // Access tokens will expire after 1 hour
        );

        $this->server->enableGrantType(
            new ClientCredentialsGrant(),
            new \DateInterval('PT1H') // Access tokens will expire after 1 hour
        );
    }

    public function getServer()
    {
        return $this->server;
    }

    public function respondToAccessTokenRequest(ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response)
    {
        try {
            return $this->server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            $response->getBody()->write($exception->getMessage());
            return $response->withStatus(500);
        }
    }

    
}

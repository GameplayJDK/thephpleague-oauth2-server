<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Grant;

use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\OAuthServerExtraException;
use League\OAuth2\Server\Grant\Traits\SessionAwareTrait;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Psr\Http\Message\ServerRequestInterface;

class RefreshTokenSessionGrant extends RefreshTokenGrant
{
    // TODO: Fix the use of trait methods using the insteadof statement.
    use SessionAwareTrait;

    /**
     * @param ServerRequestInterface $request
     * @param string $clientId
     *
     * @throws OAuthServerException
     *
     * @return array
     */
    protected function validateOldRefreshToken(ServerRequestInterface $request, $clientId)
    {
        $refreshTokenData = parent::validateOldRefreshToken($request, $clientId);

        if ($this->sessionRepository->isSessionPersisted($this->session)) {
            $linkedRefreshTokens = $this->session->getLinkedAuthCodes();
            foreach ($linkedRefreshTokens as $linkedRefreshToken) {
                if ($linkedRefreshToken->getIdentifier() === $refreshTokenData['refresh_token_id']) {
                    return $refreshTokenData;
                }
            }

            // TODO
            throw OAuthServerExtraException::invalidSession('given refresh token not linked to provided session');
        }

        return $refreshTokenData;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthorizationRequest(ServerRequestInterface $request)
    {
        return parent::validateAuthorizationRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    public function completeAuthorizationRequest(AuthorizationRequest $authorizationRequest)
    {
        return parent::completeAuthorizationRequest($authorizationRequest);
    }
}

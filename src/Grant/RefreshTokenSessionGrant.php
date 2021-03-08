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
use League\OAuth2\Server\Grant\Traits\SessionAwareTrait;
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

        $session = $this->sessionRepository->getSessionEntityByRefreshTokenIdentifier(
            $refreshTokenData['refresh_token_id']);
        // The session from the auth code takes precedence over the provided session id
        if (!\is_null($session)
            && $this->sessionRepository->isSessionInvalidated($session->getIdentifier()) === false
            && ($this->sessionRepository->isSessionPersisted($this->session) === false
                || $this->session->getIdentifier() !== $session->getIdentifier())
        ) {
            $this->session = $session;
        }

        return $refreshTokenData;
    }
}

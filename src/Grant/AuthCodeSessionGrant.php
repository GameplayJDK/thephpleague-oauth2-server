<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Grant;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Grant\Traits\SessionAwareTrait;
use Psr\Http\Message\ServerRequestInterface;
use stdClass;

class AuthCodeSessionGrant extends AuthCodeGrant
{
    // TODO: Fix the use of trait methods using the insteadof statement.
    use SessionAwareTrait;

    /**
     * Validate the authorization code.
     *
     * @param stdClass               $authCodePayload
     * @param ClientEntityInterface  $client
     * @param ServerRequestInterface $request
     *
     * @throw OAuthServerException
     */
    protected function validateAuthorizationCode(
        $authCodePayload,
        ClientEntityInterface $client,
        ServerRequestInterface $request
    ) {
        parent::validateAuthorizationCode($authCodePayload, $client, $request);

        // TODO: Do not use repository here, rather compare session linked contents to the id.
        $session = $this->sessionRepository->getSessionEntityByAuthCodeIdentifier($authCodePayload->auth_code_id);
        // The session from the auth code takes precedence over the provided session id
        if (!\is_null($session)
            && $this->sessionRepository->isSessionInvalidated($session->getIdentifier()) === false
            && ($this->sessionRepository->isSessionPersisted($this->session) === false
                || $this->session->getIdentifier() !== $session->getIdentifier())
        ) {
            $this->session = $session;
        }
    }
}

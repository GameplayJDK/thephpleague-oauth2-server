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
use League\OAuth2\Server\Exception\OAuthServerExtraException;
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

        if ($this->sessionRepository->isSessionPersisted($this->session)) {
            $linkedAuthCodes = $this->session->getLinkedAuthCodes();
            foreach ($linkedAuthCodes as $linkedAuthCode) {
                if ($linkedAuthCode->getIdentifier() === $authCodePayload->auth_code_id) {
                    return;
                }
            }

            // TODO
            throw OAuthServerExtraException::invalidSession('given auth code not linked to provided session');
        }
    }
}

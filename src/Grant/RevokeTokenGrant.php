<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Grant;

use DateInterval;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;

class RevokeTokenGrant extends AbstractGrant
{
    /**
     * @inheritDoc
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    ) {
        // TODO: Implement respondToAccessTokenRequest() method.
        //  This is already implemented, but not updated here. The rfc is https://tools.ietf.org/html/rfc7009.
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier()
    {
        return 'revoke_token';
    }
}

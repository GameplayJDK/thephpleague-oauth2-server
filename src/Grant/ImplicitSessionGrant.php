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
use League\OAuth2\Server\Grant\Traits\SessionAwareTrait;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @deprecated Use of this grant type is discouraged!
 */
class ImplicitSessionGrant extends ImplicitGrant
{
    use SessionAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    ) {
        return parent::respondToAccessTokenRequest($request, $responseType, $accessTokenTTL);
    }
}

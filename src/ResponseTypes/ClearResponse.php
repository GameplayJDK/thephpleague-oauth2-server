<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\ResponseTypes;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Psr\Http\Message\ResponseInterface;

class ClearResponse implements ResponseTypeInterface
{
    /**
     * @inheritDoc
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        // Not relevant for this response type
    }

    /**
     * @inheritDoc
     */
    public function setRefreshToken(RefreshTokenEntityInterface $refreshToken)
    {
        // Not relevant for this response type
    }

    /**
     * @inheritDoc
     */
    public function generateHttpResponse(ResponseInterface $response)
    {
        // TODO: Verify against rfc7009 at https://tools.ietf.org/html/rfc7009.
        $response = $response
            ->withStatus(200)
            ->withHeader('pragma', 'no-cache')
            ->withHeader('cache-control', 'no-store')
            ->withHeader('content-type', 'application/json; charset=UTF-8');

        $response->getBody()->write('');

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function setEncryptionKey($key = null)
    {
        // Not relevant for this response type
    }
}

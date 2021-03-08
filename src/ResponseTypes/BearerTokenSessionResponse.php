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

class BearerTokenSessionResponse extends BearerTokenResponse
{
    /**
     * {@inheritdoc}
     */
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        // TODO
        return parent::getExtraParams($accessToken);
    }
}

<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Grant;

use League\OAuth2\Server\Grant\Traits\SessionAwareTrait;

class ClientCredentialsSessionGrant extends ClientCredentialsGrant
{
    // TODO: Fix the use of trait methods using the insteadof statement.
    use SessionAwareTrait;
}

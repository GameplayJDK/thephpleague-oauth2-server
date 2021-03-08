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

class PasswordSessionGrant extends PasswordGrant
{
    // TODO: Fix the use of trait methods using the insteadof statement.
    use SessionAwareTrait;
}

<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Grant;

class RevokeTokenSessionGrant extends RevokeTokenGrant
{
    // TODO: Find the session by the refresh token to revoke in case that's desired.
    // TODO: Allow revocation of the session token itself, make sure there is no new session persisted after that.

    // ...
}

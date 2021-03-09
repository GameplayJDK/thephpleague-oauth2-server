<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\RequestTypes;

class AuthorizationWithSessionRequest extends AuthorizationRequest
{
    /**
     * @var string|null
     */
    protected $session;

    /**
     * @return string|null
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param string $session
     */
    public function setSession($session): void
    {
        $this->session = $session;
    }
}

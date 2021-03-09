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
use League\OAuth2\Server\Entities\SessionEntityInterface;

class BearerTokenWithSessionResponse extends BearerTokenResponse
{
    /**
     * @var SessionEntityInterface
     */
    protected $session;

    /**
     * @param SessionEntityInterface $session
     */
    public function setSession(SessionEntityInterface $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        $extraParams = parent::getExtraParams($accessToken);

        if ($this->session instanceof SessionEntityInterface) {
            $extraParams['session'] = $this->session->getIdentifier();
        }

        return $extraParams;
    }
}

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
     * @param ResponseTypeInterface|null $responseType
     */
    public function __construct(ResponseTypeInterface $responseType = null)
    {
        if ($responseType instanceof AbstractResponseType) {
            $this->setAccessToken($responseType->accessToken);
            $this->setRefreshToken($responseType->refreshToken);

            $this->setPrivateKey($responseType->privateKey);

            $this->setEncryptionKey($responseType->encryptionKey);
        }

        if ($responseType instanceof self && !\is_null($responseType->session)) {
            $this->setSession($responseType->session);
        }
    }

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

<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Entities;

interface SessionEntityInterface
{
    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @param string $identifier
     */
    public function setIdentifier($identifier);

    /**
     * @return AccessTokenEntityInterface[]
     */
    public function getLinkedAccessTokens();

    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     */
    public function addLinkedAccessToken(AccessTokenEntityInterface $accessTokenEntity);

    /**
     * @return AuthCodeEntityInterface[]
     */
    public function getLinkedAuthCodes();

    /**
     * @param AuthCodeEntityInterface $authCodeEntity
     */
    public function addLinkedAuthCode(AuthCodeEntityInterface $authCodeEntity);

    /**
     * @return RefreshTokenEntityInterface[]
     */
    public function getLinkedRefreshTokens();

    /**
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     */
    public function addLinkedRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity);
}

<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Grant\Traits;

use DateInterval;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\SessionEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\SessionRepositoryInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;

trait SessionAwareTrait
{
    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionRepository;

    /**
     * @var SessionEntityInterface|null
     */
    protected $session;

    /**
     * @param SessionRepositoryInterface $sessionRepository
     */
    public function setSessionRepository(SessionRepositoryInterface $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * @param ServerRequestInterface $request
     * @return SessionEntityInterface
     */
    protected function getNewOrExistingSession(ServerRequestInterface $request)
    {
        $sessionToken = $this->getRequestParameter('session_token', $request, null);

        // TODO: Do $this->decrypt($sessionToken) and use payload instead.

        if (null !== $sessionToken) {
            $session = $this->sessionRepository->getSessionEntityByIdentifier($sessionToken);
        }

        if (!isset($session)) {
            $session = $this->sessionRepository->getNewSession();
        }

        return $session;
    }

    /**
     * @param SessionEntityInterface $session
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     *
     * @return SessionEntityInterface
     */
    protected function persistNewOrExistingSession(SessionEntityInterface $session)
    {
        if ($this->sessionRepository->isSessionPersisted($session)) {
            $this->sessionRepository->persistExistingSession($session);
        } else {
            $maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

            while ($maxGenerationAttempts-- > 0) {
                $session->setIdentifier($this->generateUniqueIdentifier());
                try {
                    $this->sessionRepository->persistNewSession($session);
                } catch (UniqueTokenIdentifierConstraintViolationException $e) {
                    if ($maxGenerationAttempts === 0) {
                        throw $e;
                    }
                }
            }
        }

        return $session;
    }

    /**
     * Respond to an access token request.
     *
     * @param ServerRequestInterface $request
     * @param ResponseTypeInterface $responseType
     * @param DateInterval $accessTokenTTL
     *
     * @throws OAuthServerException
     *
     * @return ResponseTypeInterface
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    ) {
        // TODO: Get 'session' parameter and validate client. Set session also here.

        $this->session = $this->getNewOrExistingSession($request);

        try {
            $responseType = parent::respondToAccessTokenRequest($request, $responseType, $accessTokenTTL);
        } catch (OAuthServerException $e) {
            throw $e;
        } finally {
            $this->persistNewOrExistingSession($this->session);

            unset($this->session);
            $this->session = null;
        }

        return $responseType;
    }

    /**
     * Issue an access token.
     *
     * @param DateInterval $accessTokenTTL
     * @param ClientEntityInterface $client
     * @param string|null $userIdentifier
     * @param ScopeEntityInterface[] $scopes
     *
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     *
     * @return AccessTokenEntityInterface
     */
    protected function issueAccessToken(
        DateInterval $accessTokenTTL,
        ClientEntityInterface $client,
        $userIdentifier,
        array $scopes = []
    ) {
        $accessToken = parent::issueAccessToken($accessTokenTTL, $client, $userIdentifier, $scopes);

        if (isset($this->session)) {
            $this->session->addLinkedAccessToken($accessToken);
        }

        return $accessToken;
    }

    /**
     * Issue an auth code.
     *
     * @param DateInterval $authCodeTTL
     * @param ClientEntityInterface $client
     * @param string $userIdentifier
     * @param string|null $redirectUri
     * @param ScopeEntityInterface[] $scopes
     *
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     *
     * @return AuthCodeEntityInterface
     */
    protected function issueAuthCode(
        DateInterval $authCodeTTL,
        ClientEntityInterface $client,
        $userIdentifier,
        $redirectUri,
        array $scopes = []
    ) {
        $authCode = parent::issueAuthCode($authCodeTTL, $client, $userIdentifier, $redirectUri, $scopes);

        if (isset($this->session)) {
            $this->session->addLinkedAuthCode($authCode);
        }

        return $authCode;
    }

    /**
     * @param AccessTokenEntityInterface $accessToken
     *
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     *
     * @return RefreshTokenEntityInterface|null
     */
    protected function issueRefreshToken(AccessTokenEntityInterface $accessToken)
    {
        $refreshToken = parent::issueRefreshToken($accessToken);

        if (isset($this->session) && !\is_null($refreshToken)) {
            $this->session->addLinkedRefreshToken($refreshToken);
        }

        return $refreshToken;
    }

    /**
     * Return the grant identifier that can be used in matching up requests.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return parent::getIdentifier() . '_session';
    }
}

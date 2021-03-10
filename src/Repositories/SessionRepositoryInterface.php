<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Repositories;

use League\OAuth2\Server\Entities\SessionEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;

interface SessionRepositoryInterface
{
    /**
     * @return SessionEntityInterface
     */
    public function getNewSession();

    /**
     * @param SessionEntityInterface $sessionEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewSession(SessionEntityInterface $sessionEntity);

    /**
     * @param SessionEntityInterface $sessionEntity
     *
     * @return bool
     */
    public function isSessionPersisted(SessionEntityInterface $sessionEntity);

    /**
     * @param string $identifier
     *
     * @return SessionEntityInterface|null
     */
    public function getSessionEntityByIdentifier($identifier);

    /**
     * @param SessionEntityInterface $sessionEntity
     */
    public function persistExistingSession(SessionEntityInterface $sessionEntity);

    /**
     * @param string $sessionId
     */
    public function invalidateSession($sessionId);

    /**
     * @param string $sessionId
     *
     * @return bool
     */
    public function isSessionInvalidated($sessionId);
}

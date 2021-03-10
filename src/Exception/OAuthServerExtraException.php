<?php
/**
 * @author      Marcel <github@gameplayjdk.de> from Made
 * @copyright   Copyright (c) Made
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/made/oauth2-server-extra
 */

namespace League\OAuth2\Server\Exception;

use Throwable;

class OAuthServerExtraException extends OAuthServerException
{
    /**
     * Unsupported token type.
     *
     * @param string      $tokenType
     * @param string|null $hint
     * @param Throwable   $previous
     *
     * @return static
     */
    public static function unsupportedTokenType($tokenType, $hint = null, Throwable $previous = null)
    {
        $errorMessage = 'The authorization server does not support the revocation of the presented token type.';
        $hint = ($hint === null) ? \sprintf('Check the presented token type `%s`', $tokenType) : $hint;

        return new static(
            $errorMessage,
            11,
            'unsupported_token_type',
            400,
            $hint,
            null,
            $previous
        );
    }

    /**
     * Invalid session token.
     *
     * @param string|null $hint
     *
     * @return static
     */
    public static function invalidSession(string $hint = null)
    {
        return new static(
            'The provided session token is invalid.',
            12,
            'invalid_request',
            400,
            $hint
        );
    }
}

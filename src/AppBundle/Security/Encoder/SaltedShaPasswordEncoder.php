<?php
namespace AppBundle\Security\Encoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class SaltedShaPasswordEncoder extends BasePasswordEncoder
{
    const PART_LENGTH = 20;
    const SALT_LENGTH = 40;

    //region PasswordEncoderInterface

    /**
     * Encodes the raw password.
     *
     * @param string $raw The password to encode
     * @param string $salt The salt
     *
     * @return string The encoded password
     */
    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password');
        }

        $salt = $this->ensureSaltLength($salt);

        $hash = sha1($salt.md5($raw));

        return $this->mergePasswordAndSalt($hash, $salt);
    }

    /**
     * Checks a raw password against an encoded password.
     *
     * @param string $encoded An encoded password
     * @param string $raw A raw password
     * @param string $salt The salt
     *
     * @return bool true if the password is valid, false otherwise
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        $salt = $this->demergePasswordAndSalt($encoded);

        return !$this->isPasswordTooLong($raw) && $this->comparePasswords($encoded, $this->encodePassword($raw, $salt));
    }

    //endregion

    /**
     * @inheritdoc
     *
     * @param string $mergedPasswordSalt
     *
     * @return array Array consisting of password hash and salt
     */
    protected function demergePasswordAndSalt($mergedPasswordSalt)
    {
        if (empty($mergedPasswordSalt)) {
            return ['', ''];
        }

        $hashParts = str_split($mergedPasswordSalt, self::PART_LENGTH);
        $salt = $hashParts[0].$hashParts[3];
        $password = $hashParts[1].$hashParts[2];

        return [$password, $salt];
    }

    /**
     * @inheritdoc
     *
     * @param string $password
     * @param string $salt
     *
     * @return string
     */
    protected function mergePasswordAndSalt($password, $salt)
    {
        $saltParts = str_split($salt, self::PART_LENGTH);

        return sprintf('%s%s%s', $saltParts[0], $password, $saltParts[1]);
    }

    private function ensureSaltLength($salt)
    {
        if (strlen($salt) === self::SALT_LENGTH) {
            return $salt;
        }

        while (strlen($salt) < self::SALT_LENGTH) {
            $salt .= uniqid('', true);
        }

        return substr($salt, 0, self::SALT_LENGTH);
    }
}

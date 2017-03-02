<?php
namespace AppBundle\Entity;

use DateTime;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 */
class User extends AbstractEntity implements AdvancedUserInterface, EncoderAwareInterface, \Serializable
{
    const ENCODER_BCRYPT    = 'bcrypt';
    const ENCODER_MD5       = 'md5';
    const ENCODER_SHA       = 'salted_sha';

    //region Column properties

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var DateTime
     */
    protected $lastAction = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    protected $userAction;

    /**
     * @var integer
     */
    protected $userActionId;

    /**
     * @var string
     */
    protected $locationVector;

    /**
     * @var integer
     */
    protected $mailCount = 0;

    /**
     * @var integer
     */
    protected $userMailId;

    /**
     * @var integer
     */
    protected $k;

    /**
     * @var integer
     */
    protected $kWallet = 0;

    /**
     * @var integer
     */
    protected $listingAmount = 32;

    /**
     * @var string
     */
    protected $listingOrder = 'desc';

    /**
     * @var integer
     */
    protected $headerId;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var DateTime
     */
    protected $accLockout;

    /**
     * @var integer
     */
    protected $passwordChangePeriod;

    /**
     * @var integer
     */
    protected $loginRetry = 0;

    /**
     * @var DateTime
     */
    protected $dateLastLogin = '0000-00-00 00:00:00';

    /**
     * @var DateTime
     */
    protected $datePasswordChanged;

    /**
     * @var DateTime
     */
    protected $dateLoginFailed;

    /**
     * @var integer
     */
    protected $mailNotify = 0;

    /**
     * @var integer
     */
    protected $bookstyle = 0;

    /**
     * @var string
     */
    protected $settingMetadata;

    //endregion

    //region Association properties

    /** @var Node */
    protected $node;

    /** @var Mail[] */
    protected $mails;

    //endregion

    //region Column methods

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getLastAction()
    {
        return $this->lastAction;
    }

    public function setLastAction($lastAction)
    {
        $this->lastAction = $lastAction;

        return $this;
    }

    public function getUserAction()
    {
        return $this->userAction;
    }

    public function setUserAction($userAction)
    {
        $this->userAction = $userAction;

        return $this;
    }

    public function getUserActionId()
    {
        return $this->userActionId;
    }

    public function setUserActionId($userActionId)
    {
        $this->userActionId = $userActionId;

        return $this;
    }

    public function getLocationVector()
    {
        return $this->locationVector;
    }

    public function setUserLocationVector($locationVector)
    {
        $this->locationVector = $locationVector;

        return $this;
    }

    public function getMailCount()
    {
        return $this->mailCount;
    }

    public function setMailCount($mailCount)
    {
        $this->mailCount = $mailCount;

        return $this;
    }

    public function getUserMailId()
    {
        return $this->userMailId;
    }

    public function setUserMailId($userMailId)
    {
        $this->userMailId = $userMailId;

        return $this;
    }

    public function getK()
    {
        return $this->k;
    }

    public function setK($k)
    {
        $this->k = $k;

        return $this;
    }

    public function getKWallet()
    {
        return $this->kWallet;
    }

    public function setKWallet($kWallet)
    {
        $this->kWallet = $kWallet;

        return $this;
    }

    public function getListingAmount()
    {
        return $this->listingAmount;
    }

    public function setListingAmount($listingAmount)
    {
        $this->listingAmount = $listingAmount;

        return $this;
    }

    public function getListingOrder()
    {
        return $this->listingOrder;
    }

    public function setListingOrder($listingOrder)
    {
        $this->listingOrder = $listingOrder;

        return $this;
    }

    public function getHeaderId()
    {
        return $this->headerId;
    }

    public function setHeaderId($headerId)
    {
        $this->headerId = $headerId;

        return $this;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    public function getAccLockout()
    {
        return $this->accLockout;
    }

    public function setAccLockout($accLockout)
    {
        $this->accLockout = $accLockout;

        return $this;
    }

    public function getPasswordChangePeriod()
    {
        return $this->passwordChangePeriod;
    }

    public function setPasswordChangePeriod($passwordChangePeriod)
    {
        $this->passwordChangePeriod = $passwordChangePeriod;

        return $this;
    }

    public function getLoginRetry()
    {
        return $this->loginRetry;
    }

    public function setLoginRetry($loginRetry)
    {
        $this->loginRetry = $loginRetry;

        return $this;
    }

    public function getDateLastLogin()
    {
        return $this->dateLastLogin;
    }

    public function setDateLastLogin(DateTime $dateLastLogin)
    {
        $this->dateLastLogin = $dateLastLogin;

        return $this;
    }

    public function getDatePasswordChanged()
    {
        return $this->datePasswordChanged;
    }

    public function setDatePasswordChanged($datePasswordChanged)
    {
        $this->datePasswordChanged = $datePasswordChanged;

        return $this;
    }

    public function getDateLoginFailed()
    {
        return $this->dateLoginFailed;
    }

    public function setDateLoginFailed($dateLoginFailed)
    {
        $this->dateLoginFailed = $dateLoginFailed;

        return $this;
    }

    public function getMailNotify()
    {
        return $this->mailNotify;
    }

    public function setMailNotify($mailNotify)
    {
        $this->mailNotify = $mailNotify;

        return $this;
    }

    //endregion

    //region Association methods

    public function getNode()
    {
        return $this->node;
    }

    public function getMails()
    {
        return $this->mails;
    }

    public function setMails($mails)
    {
        $this->mails = $mails;

        return $this;
    }

    //endregion

    //region UserInterface

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->login;
    }

    /**
     * Returns the roles granted to the user.
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return [
            'ROLE_USER',
        ];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        return;
    }

    //endregion

    //region AdvancedUserInterface

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        $now = new DateTime();

        return (empty($this->accLockout) || $this->accLockout <= $now);
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        //TODO this should return false for users with pending registrations
        return true;
    }

    //endregion

    //region EncoderAwareInterface

    /**
     * Gets the name of the encoder used to encode the password.
     *
     * If the method returns null, the standard way to retrieve the encoder
     * will be used instead.
     *
     * @return string
     */
    public function getEncoderName()
    {
        if (strlen($this->password) === 32) {
            return self::ENCODER_MD5;
        } elseif (strlen($this->password) === 80 && $this->password[0] !== '$') {
            return self::ENCODER_SHA;
        } else {
            return self::ENCODER_BCRYPT;
        }
    }

    //endregion

    //region Serializable

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->login,
            $this->password,
            $this->accLockout,
        ]);
    }

    /**
     * @param string $serialized
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->login,
            $this->password,
            $this->accLockout
        ) = unserialize($serialized);
    }

    //endregion
}

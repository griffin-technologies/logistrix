<?php
/**
 * @author: Kieran <k.mckewen@griffin-tech.net>
 */

namespace LogistrixBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $username
     */
    private $username;
    /**
     * @var string $password
     */
    private $password;
    /**
     * @var string $plainPassword
     */
    private $plainPassword;
    /**
     * @var string $email
     */
    private $email;
    /**
     * @var bool $isActive
     */
    private $isActive;
    /**
     * @var array $roles
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->roles = [];
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return $this
     */
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $password
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function addRole($role)
    {
        $roles = $this->getRoles();

        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $roles, true)) {
            $roles[] = $role;
        }

        return $this->setRoles($roles);
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return unserialize($this->roles);
    }

    /**
     * @param array|null $roles
     * @return $this
     */
    public function setRoles($roles)
    {
        $this->roles = serialize($roles);

        return $this;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function removeRole($role)
    {
        $roles = $this->getRoles();

        if (false !== $key = array_search(strtoupper($role), $roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return (bool)in_array(strtoupper($role), $this->getRoles());
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(
            [
                $this->id,
                $this->username,
                $this->password,
                // see section on salt below
                // $this->salt,
            ]
        );
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return $this
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}

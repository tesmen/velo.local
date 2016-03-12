<?php namespace VelovitoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="VelovitoBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_name", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VelovitoBundle\Entity\Role")
     * @ORM\JoinColumn(name="role", referencedColumnName="id")
     */
    private $role;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer" )
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registered_date", type="datetime")
     */
    private $registeredDate;

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get userRoles
     *
     * @return string
     */
    public function getRoles()
    {
        return [$this->role->getName()];
    }

    public function eraseCredentials()
    {

    }

    public function serialize()
    {
        return \json_encode(array($this->id, $this->username, $this->password, // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unSerialize($serialized)
    {
        list ($this->id, $this->username, $this->password, // see section on salt below
            // $this->salt
            ) = \json_decode($serialized);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    public function getRole()
    {
        return $this->role->getName();
    }

    public function setRoles($role)
    {
        $this->role = $role;

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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set registeredDate
     *
     * @param \DateTime $registeredDate
     *
     * @return User
     */
    public function setRegisteredDate($registeredDate = null)
    {
        if(is_null($registeredDate)){
            $this->registeredDate = new \DateTime();
        } else {
            $this->registeredDate = $registeredDate;
        }



        return $this;
    }

    /**
     * Get registeredDate
     *
     * @return \DateTime
     */
    public function getRegisteredDate()
    {
        return $this->registeredDate;
    }

    /**
     * Set role
     *
     * @param \VelovitoBundle\Entity\Role $role
     *
     * @return User
     */
    public function setRole(\VelovitoBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }
}

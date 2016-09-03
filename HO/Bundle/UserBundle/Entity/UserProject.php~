<?php

namespace HO\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserProject
 *
 * @ORM\Table(name="user_project")
 * @ORM\Entity(repositoryClass="HO\Bundle\UserBundle\Entity\UserProjectRepository")
 */
class UserProject
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
     *
     * @ORM\ManyToOne(targetEntity="\HO\Bundle\UserBundle\Entity\User", inversedBy="userproject")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\HO\Bundle\MainBundle\Entity\Project", inversedBy="userproject")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

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
     * Set user
     *
     * @param \HO\Bundle\UserBundle\Entity\User $user
     * @return UserProject
     */
    public function setUser(\HO\Bundle\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HO\Bundle\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set project
     *
     * @param \HO\Bundle\MainBundle\Entity\Project $project
     * @return UserProject
     */
    public function setProject(\HO\Bundle\MainBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \HO\Bundle\MainBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
}

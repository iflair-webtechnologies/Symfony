<?php

namespace HO\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskList
 *
 * @ORM\Table(name="task_list")
 * @ORM\Entity(repositoryClass="HO\Bundle\MainBundle\Entity\TaskListRepository")
 */
class TaskList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer")
     */
    private $projectId;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated", type="integer")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="milestone_id", type="integer")
     */
    private $milestoneId;

    /**
     * @var integer
     *
     * @ORM\Column(name="uncompleted_count", type="smallint")
     */
    private $uncompletedCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="complete", type="smallint")
     */
    private $complete;

    /**
     * @var integer
     *
     * @ORM\Column(name="private", type="smallint")
     */
    private $private;

    /**
     * @var integer
     *
     * @ORM\Column(name="overdue_count", type="smallint")
     */
    private $overdueCount;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255)
     */
    private $projectName;

    /**
     * @var integer
     *
     * @ORM\Column(name="pinned", type="smallint")
     */
    private $pinned;

    /**
     * @var integer
     *
     * @ORM\Column(name="tracked", type="smallint")
     */
    private $tracked;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="completed_count", type="integer")
     */
    private $completedCount;


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
     * Set id
     *
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set projectId
     *
     * @param integer $projectId
     * @return TaskList
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Get projectId
     *
     * @return integer 
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TaskList
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return TaskList
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set milestoneId
     *
     * @param integer $milestoneId
     * @return TaskList
     */
    public function setMilestoneId($milestoneId)
    {
        $this->milestoneId = $milestoneId;

        return $this;
    }

    /**
     * Get milestoneId
     *
     * @return integer 
     */
    public function getMilestoneId()
    {
        return $this->milestoneId;
    }

    /**
     * Set uncompletedCount
     *
     * @param integer $uncompletedCount
     * @return TaskList
     */
    public function setUncompletedCount($uncompletedCount)
    {
        $this->uncompletedCount = $uncompletedCount;

        return $this;
    }

    /**
     * Get uncompletedCount
     *
     * @return integer 
     */
    public function getUncompletedCount()
    {
        return $this->uncompletedCount;
    }

    /**
     * Set complete
     *
     * @param integer $complete
     * @return TaskList
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Get complete
     *
     * @return integer 
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set private
     *
     * @param integer $private
     * @return TaskList
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return integer 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set overdueCount
     *
     * @param integer $overdueCount
     * @return TaskList
     */
    public function setOverdueCount($overdueCount)
    {
        $this->overdueCount = $overdueCount;

        return $this;
    }

    /**
     * Get overdueCount
     *
     * @return integer 
     */
    public function getOverdueCount()
    {
        return $this->overdueCount;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     * @return TaskList
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string 
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set pinned
     *
     * @param integer $pinned
     * @return TaskList
     */
    public function setPinned($pinned)
    {
        $this->pinned = $pinned;

        return $this;
    }

    /**
     * Get pinned
     *
     * @return integer 
     */
    public function getPinned()
    {
        return $this->pinned;
    }

    /**
     * Set tracked
     *
     * @param integer $tracked
     * @return TaskList
     */
    public function setTracked($tracked)
    {
        $this->tracked = $tracked;

        return $this;
    }

    /**
     * Get tracked
     *
     * @return integer 
     */
    public function getTracked()
    {
        return $this->tracked;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return TaskList
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set completedCount
     *
     * @param integer $completedCount
     * @return TaskList
     */
    public function setCompletedCount($completedCount)
    {
        $this->completedCount = $completedCount;

        return $this;
    }

    /**
     * Get completedCount
     *
     * @return integer 
     */
    public function getCompletedCount()
    {
        return $this->completedCount;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     * @return TaskList
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}

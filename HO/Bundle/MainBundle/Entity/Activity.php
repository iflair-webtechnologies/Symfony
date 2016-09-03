<?php

namespace HO\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity(repositoryClass="HO\Bundle\MainBundle\Entity\ActivityRepository")
 */
class Activity
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
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer")
     */
    private $project_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="itemid", type="integer")
     */
    private $itemid;

    /**
     * @var string
     *
     * @ORM\Column(name="todo_list_name", type="string", length=255, nullable=true)
     */
    private $todo_list_name;

    /**
     * @var string
     *
     * @ORM\Column(name="from_user_avatar_url", type="string", length=255)
     */
    private $from_user_avatar_url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="forusername", type="string", length=255)
     */
    private $forusername;

    /**
     * @var string
     *
     * @ORM\Column(name="publicinfo", type="string", length=255)
     */
    private $publicinfo;

    /**
     * @var integer
     *
     * @ORM\Column(name="foruserid", type="integer")
     */
    private $foruserid;

    /**
     * @var string
     *
     * @ORM\Column(name="itemlink", type="string", length=255)
     */
    private $itemlink;

    /**
     * @var string
     *
     * @ORM\Column(name="datetime", type="string", length=255)
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="activitytype", type="string", length=255)
     */
    private $activitytype;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255, nullable=true)
     */
    private $project_name;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="extradescription", type="text", nullable=true)
     */
    private $extradescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="isprivate", type="smallint")
     */
    private $isprivate;

    /**
     * @var string
     *
     * @ORM\Column(name="due_date", type="string", length=8)
     */
    private $due_date;

    /**
     * @var string
     *
     * @ORM\Column(name="fromusername", type="string", length=255)
     */
    private $fromusername;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="for_user_avatar_url", type="string", length=255)
     */
    private $for_user_avatar_url;

    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer")
     */
    private $userid;

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
     * Set project_id
     *
     * @param integer $projectId
     * @return Activity
     */
    public function setProjectId($projectId)
    {
        $this->project_id = $projectId;

        return $this;
    }

    /**
     * Get project_id
     *
     * @return integer 
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * Set itemid
     *
     * @param integer $itemid
     * @return Activity
     */
    public function setItemid($itemid)
    {
        $this->itemid = $itemid;

        return $this;
    }

    /**
     * Get itemid
     *
     * @return integer 
     */
    public function getItemid()
    {
        return $this->itemid;
    }

    /**
     * Set todo_list_name
     *
     * @param string $todoListName
     * @return Activity
     */
    public function setTodoListName($todoListName)
    {
        $this->todo_list_name = $todoListName;

        return $this;
    }

    /**
     * Get todo_list_name
     *
     * @return string 
     */
    public function getTodoListName()
    {
        return $this->todo_list_name;
    }

    /**
     * Set from_user_avatar_url
     *
     * @param string $fromUserAvatarUrl
     * @return Activity
     */
    public function setFromUserAvatarUrl($fromUserAvatarUrl)
    {
        $this->from_user_avatar_url = $fromUserAvatarUrl;

        return $this;
    }

    /**
     * Get from_user_avatar_url
     *
     * @return string 
     */
    public function getFromUserAvatarUrl()
    {
        return $this->from_user_avatar_url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Activity
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
     * Set forusername
     *
     * @param string $forusername
     * @return Activity
     */
    public function setForusername($forusername)
    {
        $this->forusername = $forusername;

        return $this;
    }

    /**
     * Get forusername
     *
     * @return string 
     */
    public function getForusername()
    {
        return $this->forusername;
    }

    /**
     * Set publicinfo
     *
     * @param string $publicinfo
     * @return Activity
     */
    public function setPublicinfo($publicinfo)
    {
        $this->publicinfo = $publicinfo;

        return $this;
    }

    /**
     * Get publicinfo
     *
     * @return string 
     */
    public function getPublicinfo()
    {
        return $this->publicinfo;
    }

    /**
     * Set foruserid
     *
     * @param integer $foruserid
     * @return Activity
     */
    public function setForuserid($foruserid)
    {
        $this->foruserid = $foruserid;

        return $this;
    }

    /**
     * Get foruserid
     *
     * @return integer 
     */
    public function getForuserid()
    {
        return $this->foruserid;
    }

    /**
     * Set itemlink
     *
     * @param string $itemlink
     * @return Activity
     */
    public function setItemlink($itemlink)
    {
        $this->itemlink = $itemlink;

        return $this;
    }

    /**
     * Get itemlink
     *
     * @return string 
     */
    public function getItemlink()
    {
        return $this->itemlink;
    }

    /**
     * Set datetime
     *
     * @param string $datetime
     * @return Activity
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return string 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set activitytype
     *
     * @param string $activitytype
     * @return Activity
     */
    public function setActivitytype($activitytype)
    {
        $this->activitytype = $activitytype;

        return $this;
    }

    /**
     * Get activitytype
     *
     * @return string 
     */
    public function getActivitytype()
    {
        return $this->activitytype;
    }

    /**
     * Set project_name
     *
     * @param string $projectName
     * @return Activity
     */
    public function setProjectName($projectName)
    {
        $this->project_name = $projectName;

        return $this;
    }

    /**
     * Get project_name
     *
     * @return string 
     */
    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Activity
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set extradescription
     *
     * @param string $extradescription
     * @return Activity
     */
    public function setExtradescription($extradescription)
    {
        $this->extradescription = $extradescription;

        return $this;
    }

    /**
     * Get extradescription
     *
     * @return string 
     */
    public function getExtradescription()
    {
        return $this->extradescription;
    }

    /**
     * Set isprivate
     *
     * @param integer $isprivate
     * @return Activity
     */
    public function setIsprivate($isprivate)
    {
        $this->isprivate = $isprivate;

        return $this;
    }

    /**
     * Get isprivate
     *
     * @return integer 
     */
    public function getIsprivate()
    {
        return $this->isprivate;
    }

    /**
     * Set due_date
     *
     * @param string $dueDate
     * @return Activity
     */
    public function setDueDate($dueDate)
    {
        $this->due_date = $dueDate;

        return $this;
    }

    /**
     * Get due_date
     *
     * @return string 
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * Set fromusername
     *
     * @param string $fromusername
     * @return Activity
     */
    public function setFromusername($fromusername)
    {
        $this->fromusername = $fromusername;

        return $this;
    }

    /**
     * Get fromusername
     *
     * @return string 
     */
    public function getFromusername()
    {
        return $this->fromusername;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Activity
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set for_user_avatar_url
     *
     * @param string $forUserAvatarUrl
     * @return Activity
     */
    public function setForUserAvatarUrl($forUserAvatarUrl)
    {
        $this->for_user_avatar_url = $forUserAvatarUrl;

        return $this;
    }

    /**
     * Get for_user_avatar_url
     *
     * @return string 
     */
    public function getForUserAvatarUrl()
    {
        return $this->for_user_avatar_url;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Activity
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}

<?php

namespace HO\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="HO\Bundle\MainBundle\Entity\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="canComplete", type="smallint", nullable=true)
     */
    private $canComplete;

    /**
     * @var integer
     *
     * @ORM\Column(name="project_id", type="integer")
     */
    private $projectId;

    /**
     * @var string
     *
     * @ORM\Column(name="creator_lastname", type="string", length=255)
     */
    private $creatorLastname;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_reminders", type="smallint")
     */
    private $hasReminders;

    /**
     * @var string
     *
     * @ORM\Column(name="todo_list_name", type="string", length=255)
     */
    private $todoListName;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_unread_comments", type="smallint")
     */
    private $hasUnreadComments;

    /**
     * @var string
     *
     * @ORM\Column(name="due_date_base", type="string", length=255)
     */
    private $dueDateBase;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_position", type="integer")
     */
    private $orderPosition;

    /**
     * @var string
     *
     * @ORM\Column(name="comments_count", type="string", length=255)
     */
    private $commentsCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="private", type="smallint")
     */
    private $private;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="todo_list_id", type="integer")
     */
    private $todoListId;

    /**
     * @var string
     *
     * @ORM\Column(name="predecessors", type="string", length=255)
     */
    private $predecessors;

    /**
     * @var string
     *
     * @ORM\Column(name="created_on", type="string", length=255)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="canEdit", type="smallint")
     */
    private $canEdit;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_predecessors", type="smallint")
     */
    private $hasPredecessors;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=255)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="creator_firstname", type="string", length=255)
     */
    private $creatorFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="last_changed_on", type="string", length=255)
     */
    private $lastChangedOn;

    /**
     * @var string
     *
     * @ORM\Column(name="due_date", type="string", length=255)
     */
    private $dueDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_dependencies", type="smallint")
     */
    private $hasDependencies;

    /**
     * @var integer
     *
     * @ORM\Column(name="completed", type="smallint")
     */
    private $completed;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="attachments_count", type="integer")
     */
    private $attachmentsCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="estimated_minutes", type="integer")
     */
    private $estimatedMinutes;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="priority", type="string", length=255)
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="progress", type="smallint")
     */
    private $progress;

    /**
     * @var integer
     *
     * @ORM\Column(name="harvest_enabled", type="smallint")
     */
    private $harvestEnabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="viewEstimatedTime", type="smallint")
     */
    private $viewEstimatedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_lastname", type="string", length=255, nullable=true)
     */
    private $responsiblePartyLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_firstname", type="string", length=255, nullable=true)
     */
    private $responsiblePartyFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_names", type="string", length=255, nullable=true)
     */
    private $responsiblePartyNames;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_type", type="string", length=255, nullable=true)
     */
    private $responsiblePartyType;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_summary", type="string", length=255, nullable=true)
     */
    private $responsiblePartySummary;

    /**
     * @var integer
     *
     * @ORM\Column(name="parentTaskId", type="integer")
     */
    private $parentTaskId;

    /**
     * @var integer
     *
     * @ORM\Column(name="company_id", type="integer")
     */
    private $companyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="tasklist_lockdownId", type="integer")
     */
    private $tasklistLockdownId;

    /**
     * @var integer
     *
     * @ORM\Column(name="responsible_party_id", type="integer", nullable=true)
     */
    private $responsiblePartyId;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_ids", type="string", length=255, nullable=true)
     */
    private $responsiblePartyIds;

    /**
     * @var string
     *
     * @ORM\Column(name="creator_avatar_url", type="string", length=255)
     */
    private $creatorAvatarUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="canLogTime", type="smallint", nullable=true)
     */
    private $canLogTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="creator_id", type="integer")
     */
    private $creatorId;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255)
     */
    private $projectName;

    /**
     * @var string
     *
     * @ORM\Column(name="start_date", type="string", length=255)
     */
    private $startDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="tasklist_private", type="integer")
     */
    private $tasklistPrivate;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeIsLogged", type="smallint", nullable=true)
     */
    private $timeIsLogged;

    /**
     * @var integer
     *
     * @ORM\Column(name="lockdownId", type="smallint")
     */
    private $lockdownId;


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
     * Set canComplete
     *
     * @param integer $canComplete
     * @return Task
     */
    public function setCanComplete($canComplete)
    {
        $this->canComplete = $canComplete;

        return $this;
    }

    /**
     * Get canComplete
     *
     * @return integer 
     */
    public function getCanComplete()
    {
        return $this->canComplete;
    }

    /**
     * Set projectId
     *
     * @param integer $projectId
     * @return Task
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
     * Set creatorLastname
     *
     * @param string $creatorLastname
     * @return Task
     */
    public function setCreatorLastname($creatorLastname)
    {
        $this->creatorLastname = $creatorLastname;

        return $this;
    }

    /**
     * Get creatorLastname
     *
     * @return string 
     */
    public function getCreatorLastname()
    {
        return $this->creatorLastname;
    }

    /**
     * Set hasReminders
     *
     * @param integer $hasReminders
     * @return Task
     */
    public function setHasReminders($hasReminders)
    {
        $this->hasReminders = $hasReminders;

        return $this;
    }

    /**
     * Get hasReminders
     *
     * @return integer 
     */
    public function getHasReminders()
    {
        return $this->hasReminders;
    }

    /**
     * Set todoListName
     *
     * @param string $todoListName
     * @return Task
     */
    public function setTodoListName($todoListName)
    {
        $this->todoListName = $todoListName;

        return $this;
    }

    /**
     * Get todoListName
     *
     * @return string 
     */
    public function getTodoListName()
    {
        return $this->todoListName;
    }

    /**
     * Set hasUnreadComments
     *
     * @param integer $hasUnreadComments
     * @return Task
     */
    public function setHasUnreadComments($hasUnreadComments)
    {
        $this->hasUnreadComments = $hasUnreadComments;

        return $this;
    }

    /**
     * Get hasUnreadComments
     *
     * @return integer 
     */
    public function getHasUnreadComments()
    {
        return $this->hasUnreadComments;
    }

    /**
     * Set dueDateBase
     *
     * @param string $dueDateBase
     * @return Task
     */
    public function setDueDateBase($dueDateBase)
    {
        $this->dueDateBase = $dueDateBase;

        return $this;
    }

    /**
     * Get dueDateBase
     *
     * @return string 
     */
    public function getDueDateBase()
    {
        return $this->dueDateBase;
    }

    /**
     * Set order
     *
     * @param integer $orderPosition
     * @return Task
     */
    public function setOrderPosition($orderPosition)
    {
        $this->orderPosition = $orderPosition;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set commentsCount
     *
     * @param string $commentsCount
     * @return Task
     */
    public function setCommentsCount($commentsCount)
    {
        $this->commentsCount = $commentsCount;

        return $this;
    }

    /**
     * Get commentsCount
     *
     * @return string 
     */
    public function getCommentsCount()
    {
        return $this->commentsCount;
    }

    /**
     * Set private
     *
     * @param integer $private
     * @return Task
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
     * Set status
     *
     * @param string $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set todoListId
     *
     * @param integer $todoListId
     * @return Task
     */
    public function setTodoListId($todoListId)
    {
        $this->todoListId = $todoListId;

        return $this;
    }

    /**
     * Get todoListId
     *
     * @return integer 
     */
    public function getTodoListId()
    {
        return $this->todoListId;
    }

    /**
     * Set predecessors
     *
     * @param string $predecessors
     * @return Task
     */
    public function setPredecessors($predecessors)
    {
        $this->predecessors = $predecessors;

        return $this;
    }

    /**
     * Get predecessors
     *
     * @return string 
     */
    public function getPredecessors()
    {
        return $this->predecessors;
    }

    /**
     * Set createdOn
     *
     * @param string $createdOn
     * @return Task
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return string 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set canEdit
     *
     * @param integer $canEdit
     * @return Task
     */
    public function setCanEdit($canEdit)
    {
        $this->canEdit = $canEdit;

        return $this;
    }

    /**
     * Get canEdit
     *
     * @return integer 
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Task
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set hasPredecessors
     *
     * @param integer $hasPredecessors
     * @return Task
     */
    public function setHasPredecessors($hasPredecessors)
    {
        $this->hasPredecessors = $hasPredecessors;

        return $this;
    }

    /**
     * Get hasPredecessors
     *
     * @return integer 
     */
    public function getHasPredecessors()
    {
        return $this->hasPredecessors;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return Task
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set creatorFirstname
     *
     * @param string $creatorFirstname
     * @return Task
     */
    public function setCreatorFirstname($creatorFirstname)
    {
        $this->creatorFirstname = $creatorFirstname;

        return $this;
    }

    /**
     * Get creatorFirstname
     *
     * @return string 
     */
    public function getCreatorFirstname()
    {
        return $this->creatorFirstname;
    }

    /**
     * Set lastChangedOn
     *
     * @param string $lastChangedOn
     * @return Task
     */
    public function setLastChangedOn($lastChangedOn)
    {
        $this->lastChangedOn = $lastChangedOn;

        return $this;
    }

    /**
     * Get lastChangedOn
     *
     * @return string 
     */
    public function getLastChangedOn()
    {
        return $this->lastChangedOn;
    }

    /**
     * Set dueDate
     *
     * @param string $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return string 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set hasDependencies
     *
     * @param integer $hasDependencies
     * @return Task
     */
    public function setHasDependencies($hasDependencies)
    {
        $this->hasDependencies = $hasDependencies;

        return $this;
    }

    /**
     * Get hasDependencies
     *
     * @return integer 
     */
    public function getHasDependencies()
    {
        return $this->hasDependencies;
    }

    /**
     * Set completed
     *
     * @param integer $completed
     * @return Task
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return integer 
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Task
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
     * Set attachmentsCount
     *
     * @param integer $attachmentsCount
     * @return Task
     */
    public function setAttachmentsCount($attachmentsCount)
    {
        $this->attachmentsCount = $attachmentsCount;

        return $this;
    }

    /**
     * Get attachmentsCount
     *
     * @return integer 
     */
    public function getAttachmentsCount()
    {
        return $this->attachmentsCount;
    }

    /**
     * Set estimatedMinutes
     *
     * @param integer $estimatedMinutes
     * @return Task
     */
    public function setEstimatedMinutes($estimatedMinutes)
    {
        $this->estimatedMinutes = $estimatedMinutes;

        return $this;
    }

    /**
     * Get estimatedMinutes
     *
     * @return integer 
     */
    public function getEstimatedMinutes()
    {
        return $this->estimatedMinutes;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
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
     * Set priority
     *
     * @param string $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set progress
     *
     * @param integer $progress
     * @return Task
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress
     *
     * @return integer 
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set harvestEnabled
     *
     * @param integer $harvestEnabled
     * @return Task
     */
    public function setHarvestEnabled($harvestEnabled)
    {
        $this->harvestEnabled = $harvestEnabled;

        return $this;
    }

    /**
     * Get harvestEnabled
     *
     * @return integer 
     */
    public function getHarvestEnabled()
    {
        return $this->harvestEnabled;
    }

    /**
     * Set viewEstimatedTime
     *
     * @param integer $viewEstimatedTime
     * @return Task
     */
    public function setViewEstimatedTime($viewEstimatedTime)
    {
        $this->viewEstimatedTime = $viewEstimatedTime;

        return $this;
    }

    /**
     * Get viewEstimatedTime
     *
     * @return integer 
     */
    public function getViewEstimatedTime()
    {
        return $this->viewEstimatedTime;
    }

    /**
     * Set parentTaskId
     *
     * @param integer $parentTaskId
     * @return Task
     */
    public function setParentTaskId($parentTaskId)
    {
        $this->parentTaskId = $parentTaskId;

        return $this;
    }

    /**
     * Get parentTaskId
     *
     * @return integer 
     */
    public function getParentTaskId()
    {
        return $this->parentTaskId;
    }

    /**
     * Set companyId
     *
     * @param integer $companyId
     * @return Task
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return integer 
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set tasklistLockdownId
     *
     * @param integer $tasklistLockdownId
     * @return Task
     */
    public function setTasklistLockdownId($tasklistLockdownId)
    {
        $this->tasklistLockdownId = $tasklistLockdownId;

        return $this;
    }

    /**
     * Get tasklistLockdownId
     *
     * @return integer 
     */
    public function getTasklistLockdownId()
    {
        return $this->tasklistLockdownId;
    }

    /**
     * Set creatorAvatarUrl
     *
     * @param string $creatorAvatarUrl
     * @return Task
     */
    public function setCreatorAvatarUrl($creatorAvatarUrl)
    {
        $this->creatorAvatarUrl = $creatorAvatarUrl;

        return $this;
    }

    /**
     * Get creatorAvatarUrl
     *
     * @return string 
     */
    public function getCreatorAvatarUrl()
    {
        return $this->creatorAvatarUrl;
    }

    /**
     * Set canLogTime
     *
     * @param integer $canLogTime
     * @return Task
     */
    public function setCanLogTime($canLogTime)
    {
        $this->canLogTime = $canLogTime;

        return $this;
    }

    /**
     * Get canLogTime
     *
     * @return integer 
     */
    public function getCanLogTime()
    {
        return $this->canLogTime;
    }

    /**
     * Set creatorId
     *
     * @param integer $creatorId
     * @return Task
     */
    public function setCreatorId($creatorId)
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    /**
     * Get creatorId
     *
     * @return integer 
     */
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     * @return Task
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
     * Set startDate
     *
     * @param string $startDate
     * @return Task
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return string 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set tasklistPrivate
     *
     * @param integer $tasklistPrivate
     * @return Task
     */
    public function setTasklistPrivate($tasklistPrivate)
    {
        $this->tasklistPrivate = $tasklistPrivate;

        return $this;
    }

    /**
     * Get tasklistPrivate
     *
     * @return integer 
     */
    public function getTasklistPrivate()
    {
        return $this->tasklistPrivate;
    }

    /**
     * Set timeIsLogged
     *
     * @param integer $timeIsLogged
     * @return Task
     */
    public function setTimeIsLogged($timeIsLogged)
    {
        $this->timeIsLogged = $timeIsLogged;

        return $this;
    }

    /**
     * Get timeIsLogged
     *
     * @return integer 
     */
    public function getTimeIsLogged()
    {
        return $this->timeIsLogged;
    }

    /**
     * Set lockdownId
     *
     * @param integer $lockdownId
     * @return Task
     */
    public function setLockdownId($lockdownId)
    {
        $this->lockdownId = $lockdownId;

        return $this;
    }

    /**
     * Get lockdownId
     *
     * @return integer 
     */
    public function getLockdownId()
    {
        return $this->lockdownId;
    }

    /**
     * Set responsiblePartyLastname
     *
     * @param string $responsiblePartyLastname
     * @return Task
     */
    public function setResponsiblePartyLastname($responsiblePartyLastname)
    {
        $this->responsiblePartyLastname = $responsiblePartyLastname;

        return $this;
    }

    /**
     * Get responsiblePartyLastname
     *
     * @return string 
     */
    public function getResponsiblePartyLastname()
    {
        return $this->responsiblePartyLastname;
    }

    /**
     * Set responsiblePartyId
     *
     * @param integer $responsiblePartyId
     * @return Task
     */
    public function setResponsiblePartyId($responsiblePartyId)
    {
        $this->responsiblePartyId = $responsiblePartyId;

        return $this;
    }

    /**
     * Get responsiblePartyId
     *
     * @return integer 
     */
    public function getResponsiblePartyId()
    {
        return $this->responsiblePartyId;
    }

    /**
     * Set responsiblePartySummary
     *
     * @param string $responsiblePartySummary
     * @return Task
     */
    public function setResponsiblePartySummary($responsiblePartySummary)
    {
        $this->responsiblePartySummary = $responsiblePartySummary;

        return $this;
    }

    /**
     * Get responsiblePartySummary
     *
     * @return string 
     */
    public function getResponsiblePartySummary()
    {
        return $this->responsiblePartySummary;
    }

    /**
     * Set responsiblePartyType
     *
     * @param string $responsiblePartyType
     * @return Task
     */
    public function setResponsiblePartyType($responsiblePartyType)
    {
        $this->responsiblePartyType = $responsiblePartyType;

        return $this;
    }

    /**
     * Get responsiblePartyType
     *
     * @return string 
     */
    public function getResponsiblePartyType()
    {
        return $this->responsiblePartyType;
    }

    /**
     * Set responsiblePartyFirstname
     *
     * @param string $responsiblePartyFirstname
     * @return Task
     */
    public function setResponsiblePartyFirstname($responsiblePartyFirstname)
    {
        $this->responsiblePartyFirstname = $responsiblePartyFirstname;

        return $this;
    }

    /**
     * Get responsiblePartyFirstname
     *
     * @return string 
     */
    public function getResponsiblePartyFirstname()
    {
        return $this->responsiblePartyFirstname;
    }

    /**
     * Set responsiblePartyIds
     *
     * @param string $responsiblePartyIds
     * @return Task
     */
    public function setResponsiblePartyIds($responsiblePartyIds)
    {
        $this->responsiblePartyIds = $responsiblePartyIds;

        return $this;
    }

    /**
     * Get responsiblePartyIds
     *
     * @return string 
     */
    public function getResponsiblePartyIds()
    {
        return $this->responsiblePartyIds;
    }

    /**
     * Set responsiblePartyNames
     *
     * @param string $responsiblePartyNames
     * @return Task
     */
    public function setResponsiblePartyNames($responsiblePartyNames)
    {
        $this->responsiblePartyNames = $responsiblePartyNames;

        return $this;
    }

    /**
     * Get responsiblePartyNames
     *
     * @return string 
     */
    public function getResponsiblePartyNames()
    {
        return $this->responsiblePartyNames;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Task
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get orderPosition
     *
     * @return integer 
     */
    public function getOrderPosition()
    {
        return $this->orderPosition;
    }
}

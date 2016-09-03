<?php

namespace HO\Bundle\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Milestone
 *
 * @ORM\Table(name="milestone")
 * @ORM\Entity(repositoryClass="HO\Bundle\MainBundle\Entity\MilestoneRepository")
 */
class Milestone
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
     * @ORM\Column(name="canComplete", type="smallint")
     */
    private $canComplete;

    /**
     * @var integer
     *
     * @ORM\Column(name="responsible_party_id", type="integer")
     */
    private $responsiblePartyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="completer_id", type="integer", nullable=true)
     */
    private $completerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="comments_count", type="integer")
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
     * @var string
     *
     * @ORM\Column(name="completed_on", type="string", length=255, nullable=true)
     */
    private $completedOn;

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
     * @ORM\Column(name="responsible_party_type", type="string", length=255)
     */
    private $responsiblePartyType;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_names", type="string", length=255, nullable=true)
     */
    private $responsiblePartyNames;

    /**
     * @var string
     *
     * @ORM\Column(name="isprivate", type="string", length=3)
     */
    private $isprivate;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=255)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_changed_on", type="string", length=255)
     */
    private $lastChangedOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="completed", type="smallint")
     */
    private $completed;

    /**
     * @var string
     *
     * @ORM\Column(name="reminder", type="string", length=3)
     */
    private $reminder;

    /**
     * @var string
     *
     * @ORM\Column(name="tasklists", type="text")
     */
    private $tasklists;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_firstname", type="string", length=255)
     */
    private $responsiblePartyFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="completer_firstname", type="string", length=255, nullable=true)
     */
    private $completerFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_ids", type="string", length=255)
     */
    private $responsiblePartyIds;

    /**
     * @var string
     *
     * @ORM\Column(name="resposible_party_names", type="string", length=255)
     */
    private $resposiblePartyNames;

    /**
     * @var string
     *
     * @ORM\Column(name="responsible_party_lastname", type="string", length=255)
     */
    private $responsiblePartyLastname;

    /**
     * @var integer
     *
     * @ORM\Column(name="company_id", type="integer")
     */
    private $companyId;

    /**
     * @var integer
     *
     * @ORM\Column(name="creator_id", type="integer")
     */
    private $creatorId;

    /**
     * @var string
     *
     * @ORM\Column(name="completer_lastname", type="string", length=255, nullable=true)
     */
    private $completerLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255)
     */
    private $projectName;

    /**
     * @var string
     *
     * @ORM\Column(name="deadline", type="string", length=255)
     */
    private $deadline;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
	
    private $image;
	
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
     * @return Milestone
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
     * Set canComplete
     *
     * @param integer $canComplete
     * @return Milestone
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
     * Set responsiblePartyId
     *
     * @param integer $responsiblePartyId
     * @return Milestone
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
    	/*
    	//$url = 'http://project.happyidiots.nl/projects/'.$this->projectId.'/people.json';
    	$url = 'http://project.happyidiots.nl/projects/'.$this->projectId.'/people/'.$this->responsiblePartyId.'.json';
    	
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    	curl_setopt($ch, CURLOPT_USERPWD, "blur619sleeve:X");
    	
    	$json = curl_exec($ch);
    	
    	curl_close($ch);
    	
    	if (strlen($json)) {
    		$decode = json_decode($json, true);
    		
    		if (array_key_exists('people', $decode) && count($decode['people']))
    		{
    			if(count($decode['people'] > 0)) {
	    			foreach($decode['people'] as $item)
	    			{
	    				if($item['avatar-url'] !='')
	    					return $item['avatar-url'];
	    			}
    			} else {
    				//return $this->responsiblePartyId;
    				return 'http://project.happyidiots.nl/images/noPhoto2.png';
    			}
    		}
    		return 'http://project.happyidiots.nl/images/noPhoto2.png';
    	}
    	*/
    	//die();
    	return $this->responsiblePartyId;
    }

    /**
     * Set completerId
     *
     * @param integer $completerId
     * @return Milestone
     */
    public function setCompleterId($completerId)
    {
        $this->completerId = $completerId;

        return $this;
    }

    /**
     * Get completerId
     *
     * @return integer 
     */
    public function getCompleterId()
    {
        return $this->completerId;
    }

    /**
     * Set commentsCount
     *
     * @param integer $commentsCount
     * @return Milestone
     */
    public function setCommentsCount($commentsCount)
    {
        $this->commentsCount = $commentsCount;

        return $this;
    }

    /**
     * Get commentsCount
     *
     * @return integer 
     */
    public function getCommentsCount()
    {
        return $this->commentsCount;
    }

    /**
     * Set private
     *
     * @param integer $private
     * @return Milestone
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
     * @return Milestone
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
     * Set completedOn
     *
     * @param string $completedOn
     * @return Milestone
     */
    public function setCompletedOn($completedOn)
    {
        $this->completedOn = $completedOn;

        return $this;
    }

    /**
     * Get completedOn
     *
     * @return string 
     */
    public function getCompletedOn()
    {
        return $this->completedOn;
    }

    /**
     * Set createdOn
     *
     * @param string $createdOn
     * @return Milestone
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
     * @return Milestone
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
     * Set responsiblePartyType
     *
     * @param string $responsiblePartyType
     * @return Milestone
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
     * Set isprivate
     *
     * @param string $isprivate
     * @return Milestone
     */
    public function setIsprivate($isprivate)
    {
        $this->isprivate = $isprivate;

        return $this;
    }

    /**
     * Get isprivate
     *
     * @return string 
     */
    public function getIsprivate()
    {
        return $this->isprivate;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     * @return Milestone
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
     * Set lastChangedOn
     *
     * @param string $lastChangedOn
     * @return Milestone
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
     * Set completed
     *
     * @param integer $completed
     * @return Milestone
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
     * Set reminder
     *
     * @param string $reminder
     * @return Milestone
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;

        return $this;
    }

    /**
     * Get reminder
     *
     * @return string 
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * Set tasklists
     *
     * @param string $tasklists
     * @return Milestone
     */
    public function setTasklists($tasklists)
    {
        $this->tasklists = $tasklists;

        return $this;
    }

    /**
     * Get tasklists
     *
     * @return string 
     */
    public function getTasklists()
    {
        return $this->tasklists;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Milestone
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
     * Set responsiblePartyFirstname
     *
     * @param string $responsiblePartyFirstname
     * @return Milestone
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
     * Set completerFirstname
     *
     * @param string $completerFirstname
     * @return Milestone
     */
    public function setCompleterFirstname($completerFirstname)
    {
        $this->completerFirstname = $completerFirstname;

        return $this;
    }

    /**
     * Get completerFirstname
     *
     * @return string 
     */
    public function getCompleterFirstname()
    {
        return $this->completerFirstname;
    }

    /**
     * Set responsiblePartyIds
     *
     * @param string $responsiblePartyIds
     * @return Milestone
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
     * Set resposiblePartyNames
     *
     * @param string $resposiblePartyNames
     * @return Milestone
     */
    public function setResposiblePartyNames($resposiblePartyNames)
    {
        $this->resposiblePartyNames = $resposiblePartyNames;

        return $this;
    }

    /**
     * Get resposiblePartyNames
     *
     * @return string 
     */
    public function getResposiblePartyNames()
    {
        return $this->resposiblePartyNames;
    }

    /**
     * Set responsiblePartyLastname
     *
     * @param string $responsiblePartyLastname
     * @return Milestone
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
     * Set companyId
     *
     * @param integer $companyId
     * @return Milestone
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
     * Set creatorId
     *
     * @param integer $creatorId
     * @return Milestone
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
     * Set completerLastname
     *
     * @param string $completerLastname
     * @return Milestone
     */
    public function setCompleterLastname($completerLastname)
    {
        $this->completerLastname = $completerLastname;

        return $this;
    }

    /**
     * Get completerLastname
     *
     * @return string 
     */
    public function getCompleterLastname()
    {
        return $this->completerLastname;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     * @return Milestone
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
     * Set deadline
     *
     * @param string $deadline
     * @return Milestone
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return string 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Milestone
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get days away
     *
     * @return float
     */
    public function getAway()
    {
        $deadline = strtotime( substr($this->getDeadline(), 4 , 2) . "/" . substr($this->getDeadline(), 6, 2) . "/" . substr($this->getDeadline(), 0, 4) . " 23:59:59" );

        return floor( ($deadline - time() ) / 60 / 60 / 24 );
    }

    /**
     * Set responsiblePartyNames
     *
     * @param string $responsiblePartyNames
     * @return Milestone
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
    
    public function getImage() {
    	//$url = 'http://project.happyidiots.nl/projects/'.$this->projectId.'/people.json';
    	/*$url = 'http://project.happyidiots.nl/projects/'.$this->projectId.'/people/'.$this->responsiblePartyId.'.json';
    	 
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HEADER, 0);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    	curl_setopt($ch, CURLOPT_USERPWD, "blur619sleeve:X");
    	 
    	$json = curl_exec($ch);
    	 
    	curl_close($ch);
    	 
    	if (strlen($json)) {
    		$decode = json_decode($json, true);
    	
    		if (array_key_exists('people', $decode) && count($decode['people']))
    		{
    			if(count($decode['people'] > 0)) {
    				foreach($decode['people'] as $item)
    				{
    					if($item['avatar-url'] !='')
    						return $item['avatar-url'];
    				}
    			} else {
    				//return $this->responsiblePartyId;
    				return 'http://project.happyidiots.nl/images/noPhoto2.png';
    			}
    		}
    		return 'http://project.happyidiots.nl/images/noPhoto2.png';
    	}*/return 'http://project.happyidiots.nl/images/noPhoto2.png';
    }
    
    public function getToday() {
    	
    	return \date('Ymd');	
    }
}	

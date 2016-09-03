<?php

namespace HO\Bundle\MainBundle\Controller;

use HO\Bundle\MainBundle\Entity\Activity;
use HO\Bundle\MainBundle\Entity\Milestone;
use HO\Bundle\MainBundle\Entity\TaskList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use HO\Bundle\MainBundle\Entity\Company;
use HO\Bundle\MainBundle\Entity\Project;

class APIController extends Controller
{
    private $json    = '',
            $key     = 'blur619sleeve',
            $pass    = 'X',
            $baseUrl = 'http://project.happyidiots.nl/',
            $url     = 'projects.json';

    public function __construct()
    {
        $this->json = $this->getJson();
    }

    /**
     * @Template()
     */
    public function projectListAction()
    {
        $companies = array();
        $projects = $this->getDoctrine()
            ->getRepository('UserBundle:UserProject')
            ->findBy(array(
                        'user' => $this->getUser()
        ));

        foreach($projects as $project)
        {
            $company = $project->getProject()->getCompany();

            if (!array_key_exists($company->getId(), $companies))
            {
                $companies[$company->getId()] = array(
                    'company'  => $company,
                    'projects' => array()
                );
            }

            if (!array_key_exists($project->getId(), $companies[$company->getId()]['projects']))
            {
                $companies[$company->getId()]['projects'][$project->getId()] = $project->getProject();
            }
        }

        return array(
            'companies' => $companies
        );
    }

    /**
     * Fetch JSON string
     *
     * @param string $url
     * @return mixed
     */
    private function getJson($url = '')
    {
        if (!strlen($url)) {
            $url = $this->baseUrl . $this->url;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->key:$this->pass");

        $json = curl_exec($ch);

        curl_close($ch);

        return $json;
    }

    /**
     * Fetch projects.
     *
     * @return array
     */
    private function getProjects()
    {
        return $this->getDoctrine()
            ->getRepository('MainBundle:Company')
            ->findAll();
    }

    /**
     * Fetch companies
     *
     * @return array
     */
    private function getCompanies()
    {
        $this->updateCache();

        return $this->getDoctrine()
            ->getRepository('MainBundle:Company')
            ->findAll();
    }

    /**
     * Fetch active tasks by $projectId.
     *
     * @param $projectId
     * @param $limit
     * @return mixed
     */
    public function getActiveTasks($projectId, $limit = 10)
    {
        if (!$projectId)
        {
            return array();
        }

        $lists = $this->getTodoLists($projectId);

        $tasks = array();

        foreach($lists as $list)
        {
            $url = $this->baseUrl . 'todo_lists/' . $list['id'] . '/todo_items.json?filter=upcoming'; // @todo: add limit.
            $json = $this->getJson($url);

            if (strlen($json))
            {
                $decode = json_decode($json, true);
                if (array_key_exists('todo-items', $decode) && count($decode['todo-items']))
                {
                    foreach($decode['todo-items'] as $item)
                    {
                        if (!array_key_exists($list['id'], $tasks))
                        {
                            $tasks[$list['id']] = array(
                                'list'  => $list,
                                'tasks' => array()
                            );
                        }

                        $tasks[$list['id']]['tasks'][] = $item;
                    }
                }
            }
        }

        return $tasks;
    }

    /**
     * Fetch finished tasks by $projectId.
     *
     * @param $projectId
     * @param $limit
     * @return mixed
     */
    public function getFinishedTasks($projectId, $limit = 10)
    {
        if (!$projectId)
        {
            return array();
        }

        $lists = $this->getTodoLists($projectId);

        $tasks = array();

        foreach($lists as $list)
        {
            $url = $this->baseUrl . 'todo_lists/' . $list['id'] . '/todo_items.json?filter=all'; // @todo: add limit. @todo: filter finished not working??
            $json = $this->getJson($url);

            if (strlen($json))
            {
                $decode = json_decode($json, true);
                if (array_key_exists('todo-items', $decode) && count($decode['todo-items']))
                {
                    foreach($decode['todo-items'] as $item)
                    {
                        if (!array_key_exists($list['id'], $tasks))
                        {
                            $tasks[$list['id']] = array(
                                'list'  => $list,
                                'tasks' => array()
                            );
                        }

                        $tasks[$list['id']]['tasks'][] = $item;
                    }
                }
            }
        }

        return $tasks;
    }

    /**
     * Fetch todo lists by $projectId.
     *
     * @param $projectId
     * @return array|mixed
     *
     */
    public function getTodoLists($projectId)
    {
        if (!$projectId)
        {
            return array();
        }

        $url = $this->baseUrl . 'projects/' . $projectId . '/todo_lists.json?showTasks=no';
        $json = $this->getJson($url);

        if (strlen($json))
        {
            $lists = json_decode($json, true);
            return $lists['todo-lists'];
        }

        return array();
    }

    /**
     * Get project activity.
     *
     * @param $projectId
     * @param int $limit
     * @return array|mixed
     */
    public function getActivity($projectId, $limit = 10)
    {
        $url = $this->baseUrl . 'projects/' . $projectId . '/latestActivity.json?maxItems=' . (int) $limit;
        $json = $this->getJson($url);

        if (strlen($json))
        {
            $activities = json_decode($json, true);
            return $activities;
        }

        return array();
    }

    /**
     * Update project and company cache.
     */
    public function updateCache()
    {
        $em = $this->getDoctrine()->getManager(); // Init entity manager

        // Update projects and companies.
        $this->getJson();

        if (strlen($this->json)) {
            $projects = json_decode($this->json, true);

            foreach($projects['projects'] as $project) {

                // Fetch company entity from DB.
                $c = $this->getDoctrine()
                                ->getRepository('MainBundle:Company')
                                ->find((int) $project['company']['id']);

                if (!$c)
                {
                    // Entry not found, add a new one.
                    $c = new Company();
                    $c->setId((int) $project['company']['id']);
                }

                $c->setName($project['company']['name']);

                $em->persist($c);
                $em->flush();

                // Fetch company entity from DB.
                $p = $this->getDoctrine()
                    ->getRepository('MainBundle:Project')
                    ->find((int) $project['id']);

                if (!$p)
                {
                    $p = new Project();
                    $p->setId((int) $project['id']);
                }

                $p->setName($project['name']);
                $p->setDescription($project['description']);
                $p->setLogo($project['logo']);
                // Associate company with current object.
                $p->setCompany($c);

                $em->persist($p);
                $em->flush();
            }

        }
    }

    /**
     * Fetch milestones by $projectId.
     *
     * @param $projectId
     * @return array
     */
    public function getMilestones($projectId)
    {
        if (!$projectId)
        {
            $url = $this->baseUrl . 'milestones.json?find=all';
        }
        else
        {
            $url = $this->baseUrl . 'projects/' . $projectId . '/milestones.json?find=upcoming';
        }

        $json = $this->getJson($url);

        if (strlen($json))
        {
            $return     = array();
            $milestones = json_decode($json, true);

            if (array_key_exists('milestones', $milestones))
            {
                foreach($milestones['milestones'] as $milestone)
                {
                    $deadline = strtotime( substr($milestone['deadline'], 4 , 2) . "/" . substr($milestone['deadline'], 6, 2) . "/" . substr($milestone['deadline'], 0, 4) . " 23:59:59" );

                    $milestone['away'] = floor( ($deadline - time() ) / 60 / 60 / 24 );

                    $return[] = $milestone;
                }
            }

            return $return;
        }

        return array();
    }

    /**
     * Fetch a single milestone.
     *
     * @param $milestoneId
     * @return array|mixed
     */
    public function getMilestone($milestoneId)
    {
        $url = $this->baseUrl . 'milestones/' . $milestoneId . '.json';

        $json = $this->getJson($url);

        if (strlen($json))
        {
            $milestone = json_decode($json);
            $milestone = $milestone->milestone;

            $deadline = strtotime( substr($milestone->deadline, 4 , 2) . "/" . substr($milestone->deadline, 6, 2) . "/" . substr($milestone->deadline, 0, 4) . " 23:59:59" );

            $milestone->away = floor( ($deadline - time() ) / 60 / 60 / 24 );

            return $milestone;
        }

        return array();
    }

    /**
     * @Route("/api/doupdate")
     * @Template()
     */
    public function doUpdateAction()
    {
        ini_set('max_execution_time', 3600); // 1 hour
        ini_set('memory_limit','256M');
//      $tasks = $this->updateTasks();
//      $taskLists = $this->updateTaskLists();
//      $activities = $this->updateActivities();
		//$people = $this->updatePeople();
//		$this->updateCache();
        die('DONE');

        $activities = $this->updateActivities();
        $taskLists = $this->updateTaskLists();
        $tasks = $this->updateTasks();
        $milestones = $this->updateMilestones();

        die('done.');

        return array();
    }

    public function updateMilestones()
    {
        $em   = $this->getDoctrine()->getManager();
        $url  = $this->baseUrl . 'milestones.json?find=all';
        $json = $this->getJson($url);

        if (strlen($json))
        {
            $milestones = json_decode($json, true);

            foreach($milestones['milestones'] as $milestone)
            {
                $em->createQuery('DELETE MainBundle:Milestone m WHERE m.id = ' . $milestone['id'] . '')->execute(); // Remove old record.

                $m = new Milestone();
                $m->setId((int) $milestone['id']);
                $m->setProjectId((int) $milestone['project-id']);
                $m->setProjectName($milestone['project-name']);
                $m->setCanComplete($milestone['canComplete']);
                $m->setResponsiblePartyId($milestone['responsible-party-id']);
                $m->setCommentsCount($milestone['comments-count']);
                $m->setPrivate($milestone['private']);
                $m->setStatus($milestone['status']);
                $m->setCreatedOn($milestone['created-on']);
                $m->setCanEdit($milestone['canEdit']);
                $m->setResponsiblePartyType($milestone['responsible-party-type']);
                $m->setIsprivate($milestone['isprivate']);
                $m->setCompanyName($milestone['company-name']);
                $m->setLastChangedOn($milestone['last-changed-on']);
                $m->setCompleted($milestone['completed']);
                $m->setReminder($milestone['reminder']);
                $m->setTasklists(json_encode($milestone['tasklists']));
                $m->setDescription($milestone['description']);
                $m->setResponsiblePartyFirstname($milestone['responsible-party-firstname']);
                $m->setResponsiblePartyIds($milestone['responsible-party-ids']);
                $m->setResposiblePartyNames($milestone['responsible-party-names']); // For backwards compatability.
                $m->setResponsiblePartyNames($milestone['responsible-party-names']);
                $m->setResponsiblePartyLastname($milestone['responsible-party-lastname']);
                $m->setCompanyId($milestone['company-id']);
                $m->setCreatorId($milestone['creator-id']);
                $m->setDeadline($milestone['deadline']);
                $m->setTitle($milestone['title']);

                if (array_key_exists('completer-id', $milestone) && !empty($milestone['completer-id']))
                {
                    $m->setCompleterId($milestone['completer-id']);
                }

                if (array_key_exists('completed-on', $milestone) && !empty($milestone['completed-on']))
                {
                    $m->setCompletedOn($milestone['completed-on']);
                }

                if (array_key_exists('completer-firstname', $milestone) && !empty($milestone['completer-firstname']))
                {
                    $m->setCompleterFirstname($milestone['completer-firstname']);
                }

                if (array_key_exists('completer-lastname', $milestone) && !empty($milestone['completer-lastname']))
                {
                    $m->setCompleterLastname($milestone['completer-lastname']);
                }

                $em->persist($m);
                $em->flush();
            }
        }

        return true;
    }

    /**
     * Update tasks, these incluse completed tasks.
     *
     * @author Marco Bax <marco@happy-online.nl>
     * @return bool
     */
    public function updateTasks()
    {
        $taskLists = $this->getDoctrine()->getRepository('MainBundle:TaskList')->findAll();
        $em = $this->getDoctrine()->getManager();

        foreach($taskLists as $taskList)
        {
            $url = $this->baseUrl . 'todo_lists/' . $taskList->getId() . '/tasks.json?includeCompletedTasks=true';
            $json = $this->getJson($url);

            if (strlen($json))
            {
                $tasks = json_decode($json, true);

                if (array_key_exists('todo-items', $tasks) && !empty($tasks['todo-items']))
                {
                    foreach($tasks['todo-items'] as $task)
                    {
                        $em->createQuery('DELETE MainBundle:Task t WHERE t.id = ' . $task['id'] . '')->execute(); // Remove old record.

                        $t = new \HO\Bundle\MainBundle\Entity\Task();
                        $t->setId((int) $task['id']);
                        $t->setProjectId($task['project-id']);
                        $t->setOrderPosition($task['order']);
                        $t->setCommentsCount($task['comments-count']);
                        $t->setCreatedOn($task['created-on']);
                        $t->setCanEdit($task['canEdit']);
                        $t->setHasPredecessors($task['has-predecessors']);
                        $t->setcompleted((int) $task['completed']);
                        $t->setPosition($task['position']);
                        $t->setEstimatedMinutes($task['estimated-minutes']);
                        $t->setDescription($task['description']);
                        $t->setProgress($task['progress']);
                        $t->setHarvestEnabled($task['harvest-enabled']);
                        $t->setParentTaskId($task['parentTaskId']);
                        $t->setCompanyId($task['company-id']);
                        $t->setCreatorAvatarUrl($task['creator-avatar-url']);
                        $t->setCreatorId($task['creator-id']);
                        $t->setProjectName($task['project-name']);
                        $t->setStartDate($task['start-date']);
                        $t->setTasklistPrivate($task['tasklist-private']);
                        $t->setLockdownId($task['lockdownId']);
                        $t->setCreatorLastname($task['creator-lastname']);
                        $t->setHasReminders($task['has-reminders']);
                        $t->setTodoListName($task['todo-list-name']);
                        $t->setHasUnreadComments($task['has-unread-comments']);
                        $t->setDueDateBase($task['due-date-base']);
                        $t->setPrivate($task['private']);
                        $t->setStatus($task['status']);
                        $t->setTodoListId($task['todo-list-id']);
                        $t->setPredecessors(json_encode($task['predecessors']));
                        $t->setContent($task['content']);
                        $t->setCompanyName($task['company-name']);
                        $t->setCreatorFirstname($task['creator-firstname']);
                        $t->setLastChangedOn($task['last-changed-on']);
                        $t->setDueDate($task['due-date']);
                        $t->setHasDependencies($task['has-dependencies']);
                        $t->setAttachmentsCount($task['attachments-count']);
                        $t->setPriority($task['priority']);
                        $t->setViewEstimatedTime($task['viewEstimatedTime']);
                        $t->setTasklistLockdownId($task['tasklist-lockdownId']);

                        if (array_key_exists('responsible-party-lastname', $task) && !empty($task['responsible-party-lastname']))
                        {
                            $t->setResponsiblePartyLastname($task['responsible-party-lastname']);
                        }

                        if (array_key_exists('responsible-party-id', $task) && !empty($task['responsible-party-id']))
                        {
                            $t->setResponsiblePartyId($task['responsible-party-id']);
                        }

                        if (array_key_exists('responsible-party-summary', $task) && !empty($task['responsible-party-summary']))
                        {
                            $t->setResponsiblePartySummary($task['responsible-party-summary']);
                        }

                        if (array_key_exists('responsible-party-type', $task) && !empty($task['responsible-party-type']))
                        {
                            $t->setResponsiblePartyType($task['responsible-party-type']);
                        }

                        if (array_key_exists('responsible-party-firstname', $task) && !empty($task['responsible-party-firstname']))
                        {
                            $t->setResponsiblePartyFirstname($task['responsible-party-firstname']);
                        }

                        if (array_key_exists('responsible-party-ids', $task) && !empty($task['responsible-party-ids']))
                        {
                            $t->setResponsiblePartyIds($task['responsible-party-ids']);
                        }

                        if (array_key_exists('responsible-party-names', $task) && !empty($task['responsible-party-names']))
                        {
                            $t->setResponsiblePartyNames($task['responsible-party-names']);
                        }

                        if (array_key_exists('canLogTime', $task) && !empty($task['canLogTime']))
                        {
                            $t->setCanLogTime($task['canLogTime']);
                        }

                        if (array_key_exists('timeIsLogged', $task) && !empty($task['timeIsLogged']))
                        {
                            $t->setTimeIsLogged($task['timeIsLogged']);
                        }

                        $em->persist($t);

                        $taskList->setUpdated(time());
                        $em->persist($taskList);

                        $em->flush();

                        //die('JAH');
                    }
                }
            }
        }

        return true;
    }

    public function updateTaskLists()
    {
        $projects = $this->getDoctrine()->getRepository('MainBundle:Project')->findAll();
        $em = $this->getDoctrine()->getManager();

        foreach($projects as $project)
        {
            $url = $this->baseUrl . 'projects/' . $project->getId() . '/todo_lists.json?showTasks=no';
            $json = $this->getJson($url);

            if (strlen($json))
            {
                $lists = json_decode($json, true);

                foreach($lists['todo-lists'] as $todoList)
                {
                    $em->createQuery('DELETE MainBundle:TaskList tl WHERE tl.id = ' . $todoList['id'] . '')->execute(); // Remove old record.

                    $tl = new TaskList();
                    $tl->setId((int) $todoList['id']);
                    $tl->setProjectId($project->getId());
                    $tl->setName($todoList['name']);
                    $tl->setDescription($todoList['description']);
                    $tl->setMilestoneId($todoList['milestone-id']);
                    $tl->setUncompletedCount($todoList['uncompleted-count']);
                    $tl->setComplete($todoList['complete']);
                    $tl->setPrivate($todoList['private']);
                    $tl->setOverdueCount($todoList['overdue-count']);
                    $tl->setProjectName($todoList['project-name']);
                    $tl->setPinned($todoList['pinned']);
                    $tl->setProjectId($todoList['project_id']);
                    $tl->setTracked($todoList['tracked']);
                    $tl->setPosition($todoList['position']);
                    $tl->setCompletedCount($todoList['completed-count']);

                    $em->persist($tl);
                    $em->flush();
                }
            }
        }

        return true;
    }

    public function updateActivities()
    {
        $projects = $this->getDoctrine()->getRepository('MainBundle:Project')->findAll();
        $em = $this->getDoctrine()->getManager();

        foreach($projects as $project)
        {
            $url = $this->baseUrl . 'projects/' . $project->getId() . '/latestActivity.json?maxItems=50';
            $json = $this->getJson($url);

            if (strlen($json))
            {
                $activities = json_decode($json, true);

                if ($activities['STATUS'] != 'Error')
                {
                    foreach($activities['activity'] as $activity)
                    {
                        $em->createQuery('DELETE MainBundle:Activity a WHERE a.itemid = ' . $activity['itemid'] . '')->execute(); // Remove old record.

                        $a = new Activity();
                        $a->setProjectId($project->getId());
                        $a->setItemid($activity['itemid']);
                        $a->setFromUserAvatarUrl($activity['from-user-avatar-url']);
                        $a->setDescription($activity['description']);
                        $a->setForusername($activity['forusername']);
                        $a->setPublicinfo($activity['publicinfo']);
                        $a->setForuserid($activity['foruserid']);
                        $a->setItemlink($activity['itemlink']);
                        $a->setDatetime($activity['datetime']);
                        $a->setActivitytype($activity['activitytype']);
                        $a->setLink($activity['link']);
                        $a->setExtradescription($activity['extradescription']);
                        $a->setIsprivate($activity['isprivate']);
                        $a->setDueDate($activity['due-date']);
                        $a->setFromusername($activity['fromusername']);
                        $a->setType($activity['type']);
                        $a->setForUserAvatarUrl($activity['for-user-avatar-url']);
                        $a->setUserid($activity['userid']);

                        if (array_key_exists('project-name', $activity) && !empty($activity['project-name']))
                        {
                            $a->setProjectName($activity['project-name']);
                        }

                        if (array_key_exists('todo-list-name', $activity) && !empty($activity['todo-list-name']))
                        {
                            $a->setTodoListName($activity['todo-list-name']);
                        }

                        if (array_key_exists('publicinfo', $activity) && !empty($activity['publicinfo']))
                        {
                            $a->setPublicinfo($activity['publicinfo']);
                        }

                        $em->persist($a);
                        $em->flush();
                    }
                }
            }
        }

        return true;
    }
    
    public function updatePeople()
    {
    	$projects = $this->getDoctrine()->getRepository('MainBundle:Project')->findAll();
    	$em = $this->getDoctrine()->getManager();
    
    	foreach($projects as $project)
    	{
    		$url = $this->baseUrl . '/people.json?page=2&pageSize=50';
    		$json = $this->getJson($url);
    
    		if (strlen($json))
    		{
    			$peoples = json_decode($json, true);
    
    			if (array_key_exists('people', $peoples) && count($peoples['people']))
    			{
    				foreach($peoples['people'] as $people)
    				{
    					if($people['avatar-url'] !='')
    						echo $people['avatar-url'];
    				}
    			}
    		}
    	}
    
    	return true;
    }
}

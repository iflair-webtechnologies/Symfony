<?php

namespace HO\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard")
     * @Template()
     */
    public function indexAction()
    {
        $projectIds = array();
        foreach($this->getDoctrine()->getRepository('UserBundle:UserProject')->findBy(array('user' => $this->getUser())) as $project)
        {
            $projectIds[] = $project->getProject()->getId();
        }

        $activities = $this->getDoctrine()
            ->getRepository('MainBundle:Activity')
            ->findBy(array(
                'project_id' => $projectIds,
                'type'       => 'task'
            ));		
        return array(
            'activities' => $activities
        );
    }

    /**
     * @Route("/dashboard/project/{id}")
     * @param $id
     * @param bool $returnCount
     * @return array
     * @Template()
     */
    public function detailAction($id, $returnCount = false)
    {
        $activities = $this->getDoctrine()
            ->getRepository('MainBundle:Activity')
            ->findBy(array(
                'project_id' => $id,
                'type'       => 'task'
            ));

        $count = count($activities);

        if ($returnCount)
        {
            return $count;
        }

        $cache    = $this->get('cache');
        $cache->setNamespace('ho.mainbundle.cache');
        $cacheKey = $this->getUser()->getId() . '.ho.mainbundle.detail.' . $id . '.counts';
        if (false === ($counts = $cache->fetch($cacheKey)))
        {
            $finishedCount = $this->detailFinishedAction($id, TRUE);
            $todoCount     = $this->detailTodoAction($id, TRUE);

            $counts = array(
                'activities' => $count,
                'todo'       => $todoCount,
                'finished'   => $finishedCount
            );

            $cache->save($cacheKey, $counts, 21600); //TTL 6h
        }

        $project = $this->getDoctrine()
            ->getRepository('MainBundle:Project')
            ->find((int) $id);

        return !$project ? $this->redirect(404) : array('project' => $project, 'activities' => $activities, 'counts' => $counts);
    }

    /**
     * Get active todo's (tasks).
     *
     * @Route("/dashboard/todo")
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function todoAction()
    {

//        $cacheKey = $this->getUser()->getId() . '.ho.mainbundle.todo.tasks';
//        $cache    = $this->get('cache');
//        $cache->setNamespace('ho.mainbundle.cache');


        $projects    = $this->getDoctrine()->getRepository('UserBundle:UserProject')->findBy(array('user' => $this->getUser()));

//        if (false === ($tasks = $cache->fetch($cacheKey)))
//        {
            $tasks = array();
            foreach($projects as $project)
            {
                //$getTasks = $this->get('ho.api')->getFinishedTasks($project->getProject()->getId(), 10);
                $getTasks = $this->getDoctrine()
                    ->getRepository('MainBundle:Task')
                    ->findBy(array(
                            'projectId'  => $project->getProject()->getId(),
                            'status'     => 'new'
                        ), array(
                            'todoListName' => 'ASC',
                        ),
                        10 // Limit.
                    );

                $tasks = array_merge($tasks, $getTasks);
            }

//            $cache->save($cacheKey, $tasks, 21600); //TTL 6h
//        }

        return array('tasks' => $tasks);
    }

    /**
     * Get active todo's (tasks) for project
     *
     * @Route("/dashboard/project/{id}/todo")
     * @param $id
     * @param bool $returnCount
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function detailTodoAction($id, $returnCount = false)
    {
        $tasks = $this->getDoctrine()
            ->getRepository('MainBundle:Task')
            ->findBy(array(
                'projectId'  => $id,
                'status'     => 'new'
            ), array(
                'todoListName' => 'ASC'
            ));

        $count = count($tasks);

        if ($returnCount)
        {
            return $count;
        }

        $cache    = $this->get('cache');
        $cache->setNamespace('ho.mainbundle.cache');
        $cacheKey = $this->getUser()->getId() . '.ho.mainbundle.detail.' . $id . '.counts';
        if (false === ($counts = $cache->fetch($cacheKey)))
        {
            $finishedCount = $this->detailFinishedAction($id, TRUE);
            $todoCount     = $this->detailTodoAction($id, TRUE);

            $counts = array(
                'activities' => $count,
                'todo'       => $todoCount,
                'finished'   => $finishedCount
            );

            $cache->save($cacheKey, $counts, 21600); //TTL 6h
        }

        $project = $this->getDoctrine()
            ->getRepository('MainBundle:Project')
            ->find((int) $id);

        return !$project ? $this->redirect(404) : array('project' => $project, 'tasks' => $tasks, 'counts' => $counts);
    }

    /**
     * @Route("/dashboard/finished")
     * @return array
     * @Template()
     */
    public function finishedAction()
    {
//        $cacheKey = $this->getUser()->getId() . '.ho.mainbundle.finished.tasks';
//        $cache    = $this->get('cache');
//        $cache->setNamespace('ho.mainbundle.cache');

        $projects    = $this->getDoctrine()->getRepository('UserBundle:UserProject')->findBy(array('user' => $this->getUser()));
//        if (false === ($tasks = $cache->fetch($cacheKey)))
//        {
            $tasks = array();
            foreach($projects as $project)
            {
                //$getTasks = $this->get('ho.api')->getFinishedTasks($project->getProject()->getId(), 10);
                $getTasks = $this->getDoctrine()
                    ->getRepository('MainBundle:Task')
                    ->findBy(array(
                        'projectId'  => $project->getProject()->getId(),
                        'status'     => 'completed',
                        'completed'  => 1
                    ), array(
                        'todoListName' => 'ASC',
                    ),
                    10 // Limit.
                    );

                $tasks = array_merge($tasks, $getTasks);
            }

//             $cache->save($cacheKey, $tasks, 21600); //TTL 6h
//        }

        return array('tasks' => $tasks);
    }

    /**
     * @Route("/dashboard/project/{id}/finished")
     * @return array
     * @param bool $returnCount
     * @param $id
     * @Template()
     */
    public function detailFinishedAction($id, $returnCount = false)
    {
        $tasks = $this->getDoctrine()
            ->getRepository('MainBundle:Task')
            ->findBy(array(
                'projectId'  => $id,
                'status'     => 'completed',
                'completed'  => 1
            ), array(
                'todoListName' => 'ASC'
            ));

        $count = count($tasks);

        if ($returnCount)
        {
            return $count;
        }

        $cache    = $this->get('cache');
        $cache->setNamespace('ho.mainbundle.cache');
        $cacheKey = $this->getUser()->getId() . '.ho.mainbundle.finished.' . $id . '.counts';
        if (false === ($counts = $cache->fetch($cacheKey)))
        {
            $activityCount = $this->detailAction($id, TRUE);
            $todoCount     = $this->detailTodoAction($id, TRUE);

            $counts = array(
                'activities' => $activityCount,
                'todo'       => $todoCount,
                'finished'   => $count
            );

            $cache->save($cacheKey, $counts, 21600); //TTL 6h
        }

        $project = $this->getDoctrine()
            ->getRepository('MainBundle:Project')
            ->find((int) $id);

        return !$project ? $this->redirect(404) : array('project' => $project, 'tasks' => $tasks, 'counts' => $counts);
    }

    /**
     * @Route("/dashboard/milestones")
     * @return array
     * @Template()
     */
    public function milestonesAction()
    {
        $milestones = $this->getDoctrine()
            ->getRepository('MainBundle:Milestone')
            ->findBy(array(
                'completed'  => '0'
            ));

        return array('milestones' => $milestones);
    }

    /**
     * @Route("/dashboard/project/{id}/milestones")
     * @return array
     * @param $id
     * @Template()
     */
    public function detailMilestonesAction($id)
    {
        $milestones = $this->getDoctrine()
            ->getRepository('MainBundle:Milestone')
            ->findBy(array(
                'projectId' => $id,
                'completed'  => '0'
            ));

        $project = $this->getDoctrine()
            ->getRepository('MainBundle:Project')
            ->find((int) $id);

        return array(
            'project'    => $project,
            'milestones' => $milestones
        );
    }

    /**
     * @Route("/dashboard/milestone/{id}")
     * @return array
     * @param $id
     * @Template
     */
    public function milestoneAction($id)
    {
        $milestone = $this->getDoctrine()->getRepository('MainBundle:Milestone')->find($id);

        return array(
            'milestone' => $milestone
        );
    }

    /**
     * @Route("/dashboard/project/{id}/milestone/{milestoneid}")
     * @return array
     * @param $id
     * @param $milestoneid
     * @Template
     */
    public function detailMilestoneAction($id, $milestoneid)
    {
        $milestone = $this->getDoctrine()->getRepository('MainBundle:Milestone')->find($milestoneid);

        $project = $this->getDoctrine()
            ->getRepository('MainBundle:Project')
            ->find((int) $id);

        return array(
            'project'   => $project,
            'milestone' => $milestone
        );
    }
}

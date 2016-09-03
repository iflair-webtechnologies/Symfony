<?php

namespace HO\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class PartialController extends Controller
{
    /**
     * @return array
     * @Template
     */
    public function notificationAction()
    {
        $notifications = $this->getDoctrine()->getRepository('MainBundle:Notification')->getLatest(2);

        return array(
            'notifications' => $notifications
        );
    }

    /**
     * @param Request $request
     * @param bool $projectId
     * @param array $counts
     * @return array
     * @Template()
     */
    public function dashboardCategoriesAction(Request $request, $projectId = false, $counts = array())
    {
        // Set defaults.
        if (!count($counts))
        {
            $counts = array(
                'activities' => 10,
                'todo'       => 10,
                'finished'   => 10
            );
        }

        if (!$projectId)
        {
            $tabs = array(
                array(
                    'path'  => $this->generateUrl('ho_main_dashboard_index'),
                    'title' => 'Activiteiten',
                    'match' => array('ho_main_dashboard_index'),
                    'number' => $counts['activities']
                ),
                array(
                    'path'  => $this->generateUrl('ho_main_dashboard_todo'),
                    'title' => 'Komende taken',
                    'match' => array('ho_main_dashboard_todo'),
                    'number' => $counts['todo']
                ),
                array(
                    'path'  => $this->generateUrl('ho_main_dashboard_finished'),
                    'title' => 'Afgeronde taken',
                    'match' => array('ho_main_dashboard_finished'),
                    'number' => $counts['finished']
                )
            );
        } else {
            $tabs = array(
                array(
                    'path'  => $this->generateUrl('ho_main_dashboard_detail', array('id' => $projectId)),
                    'title' => 'Activiteiten',
                    'match' => array('ho_main_dashboard_detail'),
                    'number' => $counts['activities']
                ),
                array(
                    'path'  => $this->generateUrl('ho_main_dashboard_detailtodo', array('id' => $projectId)),
                    'title' => 'Komende taken',
                    'match' => array('ho_main_dashboard_detailtodo'),
                    'number' => $counts['todo']
                ),
                array(
                    'path'  => $this->generateUrl('ho_main_dashboard_detailfinished', array('id' => $projectId)),
                    'title' => 'Afgeronde taken',
                    'match' => array('ho_main_dashboard_detailfinished'),
                    'number' => $counts['finished']
                )
            );
        }

        return array(
            'tabs'      => $tabs,
            'request'   => $request,
            'counts'    => $counts,
            'routename' => $request->attributes->get('_route')
        );
    }

    /**
     * @param Request $request
     * @return array
     * @param bool $title
     * @Template()
     */
    public function headerAction(Request $request, $title = false)
    {
        $t = $this->getTitle($request);

        if ($title)
        {
            $t .= $title;
        }


        return array(
            'title'     => $t
        );
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getTitle(Request $request)
    {
        $routename = $request->attributes->get('_route');

        $title = '';
        switch($routename) {
            case "ho_main_dashboard_index":
            case "ho_main_dashboard_detail":
                $title = "Activiteiten";
                break;
            case "ho_main_dashboard_todo":
            case "ho_main_dashboard_detailtodo":
                $title = "Komende taken";
                break;
            case "ho_main_dashboard_finished":
            case "ho_main_dashboard_detailfinished":
                $title = "Afgeronde taken";
                break;
            case "ho_main_dashboard_milestones":
            case "ho_main_dashboard_detailmilestones":
                $title = "Milestones";
                break;
            case "ho_main_dashboard_milestone":
            case "ho_main_dashboard_detailmilestone":
                $title = "Milestone detail";
                break;
        }

        return $title;
    }

    /**
     * @param array $tabs
     * @param Request $request
     * @return array
     * @Template()
     */
    public function tabsAction(Request $request, $tabs = array())
    {
        if (empty($tabs)) {
            switch($request->get('_route')){
                case "ho_main_dashboard_index":
                case "ho_main_dashboard_todo":
                case "ho_main_dashboard_finished":
                case "ho_main_dashboard_milestones":
                case "ho_main_dashboard_milestone":
                    $tabs = array(
                        array(
                            'path'  => $this->generateUrl('ho_main_dashboard_index'),
                            'title' => 'Overzicht',
                            'match' => array('ho_main_dashboard_index', 'ho_main_dashboard_finished', 'ho_main_dashboard_todo')
                        ),
                        array(
                            'path'  => $this->generateUrl('ho_main_dashboard_milestones'),
                            'title' => 'Milestones',
                            'match' => array('ho_main_dashboard_milestones', 'ho_main_dashboard_milestone')
                        )
                    );
                break;

                case "ho_main_dashboard_detail":
                case "ho_main_dashboard_detailtodo":
                case "ho_main_dashboard_detailfinished":
                case "ho_main_dashboard_detailmilestones":
                case "ho_main_dashboard_detailmilestone":
                    $tabs = array(
                        array(
                            'path'  => $this->generateUrl('ho_main_dashboard_detail', array('id' => $request->get('id'))),
                            'title' => 'Overzicht',
                            'match' => array('ho_main_dashboard_detail', 'ho_main_dashboard_detailtodo', 'ho_main_dashboard_detailfinished')
                        ),
                        array(
                            'path'  => $this->generateUrl('ho_main_dashboard_detailmilestones', array('id' => $request->get('id'))),
                            'title' => 'Milestones',
                            'match' => array('ho_main_dashboard_detailmilestones', 'ho_main_dashboard_detailmilestone')
                        )
                    );
                    break;
            }
        }

        return array(
            'tabs'    => $tabs,
            'request' => $request
        );
    }
}

<?php

namespace HO\Bundle\MainBundle\Controller;

use HO\Bundle\UserBundle\Entity\UserProject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use HO\Bundle\MainBundle\Entity\Project;
use HO\Bundle\UserBundle\Entity\User;
use HO\Bundle\UserBundle\Form\UserType;

class AdminController extends Controller
{
    /**
     * @Route("/admin")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'tabs' => $this->getTabs()
        );
    }

    /**
     * @Route("/admin/users")
     * @return array
     * @Template()
     */
    public function usersAction()
    {
        $users = $this->getDoctrine()->getRepository('UserBundle:User')->findAll();

        return array(
            'tabs' => $this->getTabs(),
            'users' => $users
        );
    }

    /**
     * @Route("/admin/user/add")
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function addUserAction(Request $request)
    {
        $um   = $this->container->get('fos_user.user_manager');
        $user = $um->createUser();

        $form = $this->createFormBuilder($user)
            ->add('username', 'text', array(
                'required' => true,
                'label' => 'Gebruikersnaam'
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => 'E-mailadres'
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Deze wachtwoorden komen niet overeen',
                'required' => true,
                'first_options'  => array('label' => 'Wachtwoord'),
                'second_options' => array('label' => 'Wachtwoord bevestigen'),
            ))
            ->add('save', 'submit', array(
                'label' => 'Gebruiker opslaan'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user->setPlainPassword($form->getData('password'));
            $user->setEnabled(true);

            $em->persist($user);
            $em->flush();

            $email = $user->getEmail();
            $message = \Swift_Message::newInstance()
                ->setSubject('Welkom bij het portaal van Happy Idiots')
                ->setFrom('mailer@happyidiots.nl')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'MainBundle:Mail:userCreated.html.twig',
                        array(
                            'user' => $user
                        ) // parameters
                    ),
                    'text/html'
                );
            try {
                $this->get('mailer')->send($message);
            } catch(Exception $e) { /* log or somethin' */ }

            if (!$user->hasRole('ROLE_CUSTOMER') && !$user->hasRole('ROLE_ADMIN'))
            {
                $user->addRole('ROLE_CUSTOMER');
            }

            $um->updateUser($user, true);

            return $this->redirect($this->generateUrl('ho_main_admin_users'));
        }

        return array(
            'tabs' => $this->getTabs(),
            'form' => $form->createView()
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @Route("/admin/user/{id}/changepassword")
     * @Template()
     * @return array
     */
    public function changePasswordAction(Request $request, $id)
    {
        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->find((int) $id);

        $form = $this->createFormBuilder($user)
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Deze wachtwoorden komen niet overeen',
                'required' => true,
                'first_options'  => array('label' => 'Wachtwoord'),
                'second_options' => array('label' => 'Wachtwoord bevestigen'),
            ))
            ->add('save', 'submit', array(
                'label' => 'Wachtwoord wijzigen'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $user->setPlainPassword($form->get('password')->getData());

            $em->persist($user);
            $em->flush();

            $um = $this->container->get('fos_user.user_manager');

            $um->updateUser($user, true);

            return $this->redirect($this->generateUrl('ho_main_admin_users'));
        }

        return array(
            'tabs' => $this->getTabs(),
            'form' => $form->createView(),
            'user' => $user
        );
    }

    /**
     * @Route("/admin/user/{id}/edit")
     * @param $id
     * @param Request $request
     * @return array
     * @Template()
     */
    public function editUserAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('UserBundle:User')->find((int) $id);

        $companies = $this->getDoctrine()->getRepository('MainBundle:Company')->findAll();

        $projects = array();
        foreach($companies as $company)
        {
            $companyProjects = $this->getDoctrine()->getRepository('MainBundle:Project')->findBy(array(
                'company' => $company,
            ), array(
                'name' => 'ASC'
            ));

            foreach($companyProjects as $project)
            {
                $projects[] = $project;
            }
        }

        $userProjects = $this->getDoctrine()->getRepository('UserBundle:UserProject')->findBy(array(
            'user' => $user,
        ));

        $data = array();
        foreach($userProjects as $userProject)
        {
            $data[] = $userProject->getProject()->getId();
        }

        $form = $this->createForm(new UserType(array('projects' => $projects, 'data' => $data)), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $um = $this->container->get('fos_user.user_manager');
            $em = $this->getDoctrine()->getManager();

            //$user->setPlainPassword($form->getData('password'));

            $em->persist($user);
            $em->flush();

            $formVars = $this->get('request')->request->get('user');


            // Delete previous projects.
            $em->createQuery('DELETE UserBundle:UserProject up WHERE up.user = ' . (string) $user->getId() . '')->execute();

            foreach($formVars['projects'] as $projectId)
            {
                $project = $this->getDoctrine()->getRepository('MainBundle:Project')->find($projectId);

                $up = new UserProject();
                $up->setUser($user);
                $up->setProject($project);

                $em->persist($up);
                $em->flush();
            }

            $um->updateUser($user, true);

            return $this->redirect($this->generateUrl('ho_main_admin_users'));
        }

        return array(
            'form' => $form->createView(),
            'user' => $user,
            'tabs' => $this->getTabs()
        );
    }

    /**
     * @return array
     */
    public function getTabs()
    {
        // Define default tabs
        $tabs = array(
            array(
                'path'  => $this->generateUrl('ho_main_admin_index'),
                'title' => 'Admin',
                'match' => array('ho_main_admin_index')
            ),
            array(
                'path'  => $this->generateUrl('ho_main_admin_users'),
                'title' => 'Gebruikers',
                'match' => array('ho_main_admin_users', 'ho_main_admin_adduser', 'ho_main_admin_edituser')
            ),
            array(
                'path'  => $this->generateUrl('ho_main_notification_index'),
                'title' => 'Notificaties',
                'match' => array('ho_main_notification_index', 'ho_main_notification_create')
            )
        );

        return $tabs;
    }
}

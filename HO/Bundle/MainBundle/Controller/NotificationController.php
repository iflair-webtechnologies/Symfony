<?php

namespace HO\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

use HO\Bundle\MainBundle\Entity\Notification;

class NotificationController extends Controller
{
    /**
     * @Route("/notifications/")
     * @Template()
     */
    public function indexAction()
    {
        // Fetch notifications.
        $notifications = $this->getDoctrine()->getRepository('MainBundle:Notification')->findAll();

        return array(
            'notifications' => $notifications,
            'tabs'          => $this->getTabs()
        );
    }

    /**
     * @Route("/notifications/create")
     * @param Request $request
     * @Template()
     * @return array
     */
    public function createAction(Request $request)
    {
        $notification = new Notification();

        $form = $this->createFormBuilder($notification)
            ->add('message', 'textarea', array(
                'label' => 'Notificatie bericht',
                'attr'  => array(
                    'class' => 'tinymce'
                )
            ))
            ->add('sendmail', 'choice', array(
                'choices' => array('1' => 'Ja', '0' => 'Nee'),
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label'    => 'Verstuur e-mail?'
            ))
            ->add('save', 'submit', array(
                'label' => 'Notificatie opslaan'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($notification);
            $em->flush();

            $data = $form->getData();

            if ($data->sendmail)
            {
                $customers = $em->createQueryBuilder()
                    ->select('u')
                    ->from('UserBundle:User', 'u')
                    ->where('u.roles LIKE :roles')
                    ->setParameter('roles', '%"ROLE_CUSTOMER"%')
                    ->getQuery()
                    ->getResult();

                foreach($customers as $customer)
                {
                    $email = $customer->getEmail();
                    $message = \Swift_Message::newInstance()
                        ->setSubject('U heeft een notificatie ontvangen van Happy Idiots')
                        ->setFrom('mailer@happyidiots.nl')
                        ->setTo($email)
                        ->setBody(
                            $this->renderView(
                                'MainBundle:Mail:notificationReceived.html.twig',
                                array() // parameters
                            ),
                            'text/html'
                        );
                    try {
                        $this->get('mailer')->send($message);
                    } catch(Exception $e)
                    {
                        continue;
                    }

                }
            }

            return $this->redirect($this->generateUrl('ho_main_notification_index'));
        }

        return array(
            'form' => $form->createView(),
            'tabs' => $this->getTabs()
        );
    }

    /**
     * @return array
     * @todo: make this a service container
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

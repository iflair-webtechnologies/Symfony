<?php

namespace HO\Bundle\UserBundle\Form;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

use HO\Bundle\UserBundle\Form\Type\ProjectType;

class UserType extends AbstractType
{
    private $projects;
    private $data;

    public function __construct($options = array())
    {
        $this->projects = array();

        if (array_key_exists('projects', $options))
        {
            foreach($options['projects'] as $project)
            {
                $this->projects[$project->getId()] = $project->getCompany()->getName() . ' | ' . $project->getName();
            }
        }

        if (array_key_exists('data', $options))
        {
            $this->data = $options['data'];
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', 'text', array(
                'required' => true,
                'label' => 'Gebruikersnaam'
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => 'E-mailadres'
            ))
            ->add('projects', 'choice', array(
                'mapped'   => false,
                'label'    => 'Toegewezen aan projecten',
                'multiple' => true,
                'expanded' => true,
                'choices'  => $this->projects,
                'data'     => $this->data
            ))
            ->add('save', 'submit', array(
                'label' => 'Gebruiker opslaan',
                'attr'  => array(
                    'class' => 'btn btn-large'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HO\Bundle\UserBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'user';
    }
}
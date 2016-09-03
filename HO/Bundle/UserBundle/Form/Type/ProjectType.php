<?php

namespace HO\Bundle\UserBundle\Form\Type;

use
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder
//            ->add('project', 'entity', array(
//                'class'         => 'HO\Bundle\MainBundle\Entity\Project',
//                'query_builder' => function ($repository) { return $repository->createQueryBuilder('p')->orderBy('p.name', 'ASC'); },
//            ))
//            ->add('count', 'integer')
//        ;

        $builder->add('name', 'text', array(
            'label' => 'Projectnaam'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HO\Bundle\MainBundle\Entity\Project',
        ));
    }

    public function getName()
    {
        return 'project';
    }
}
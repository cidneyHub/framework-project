<?php

namespace Findo\Bundle\FinDoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('id', null, array('read_only' => true))
            ->add('text',
//            ->add('text', 'text')
//            ->add('finished', null)
            array(
                'type' => new \findo\Bundle\FinDoBundle\Form\ItemType(),
            ))
            ->add('save', 'submit')
        ;
    }
    
//    /**
//     * @param OptionsResolverInterface $resolver
//     */
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Findo\Bundle\FinDoBundle\Entity\ToDoItem'
//        ));
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'item';
    }
}

<?php

namespace Bse\SelectionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SelectionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ageFrom18To22')
            ->add('ageFrom23To25')
            ->add('dureeLicenceFrom3To4')
            ->add('dureeLicenceFrom5To6')
            ->add('dureeLicenceFrom7To8')
            ->add('typeDiplome')
            ->add('typeSysteme')
            ->add('etablissement')
            ->add('mentionAssezBien')
            ->add('mentionBien')
            ->add('mentionTresBien')

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bse\SelectionBundle\Entity\Selection'            
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bse_selectionbundle_selection';
    }
}

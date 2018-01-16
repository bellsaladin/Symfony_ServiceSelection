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
            ->add('faculte')
            ->add('filiere')
            ->add('ageFrom18To22')
            ->add('ageFrom23To25')
            ->add('dureeLicenceFrom3To4')
            ->add('dureeLicenceFrom5To6')
            ->add('dureeLicenceFrom7To8')
            ->add('typeDiplomeLFouLP')
            ->add('typeDiplome')
            ->add('typeSystemeLMDouAncien')
            ->add('typeSysteme')
            ->add('etablissement')
            ->add('mentionAssezBien')
            ->add('mentionBien')
            ->add('mentionTresBien')
            
            ->add('noteM1From5To10')
            ->add('noteM1From10To15')
            ->add('noteM1From15To20')
            
            ->add('noteM2From5To10')
            ->add('noteM2From10To15')
            ->add('noteM2From15To20')
            
            ->add('noteM3From5To10')
            ->add('noteM3From10To15')
            ->add('noteM3From15To20')
            
            ->add('noteM4From5To10')
            ->add('noteM4From10To15')
            ->add('noteM4From15To20')
            
            ->add('noteM5From5To10')
            ->add('noteM5From10To15')
            ->add('noteM5From15To20')
            
            ->add('noteM6From5To10')
            ->add('noteM6From10To15')
            ->add('noteM6From15To20')
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

<?php

namespace App\Form;

use App\Entity\Empresa;
use App\Entity\Sector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmpresaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       
     
        $builder
            ->add('Nombre')
            ->add('Telefono')
            ->add('Email');
  /*$builder->add('Sector', EntityType::class, [
    // looks for choices from this entity
    'class' => Sector::class,
   'choice_label' => 'nombre']);*/
        
  

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
          //$resolver->setRequired('datos');
        
        $resolver->setDefaults([
            'data_class' => Empresa::class,
        ]);
    }
}

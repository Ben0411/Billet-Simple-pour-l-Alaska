<?php

namespace Form;

use Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('file', FileType::class, array('constraints' => array(new File(array(
                'mimeTypes' => array('image/jpeg','image/png','image/gif'),
                'mimeTypesMessage' => "Fichier non autorisé. Votre fichier doit être au format .jpeg, .png ou .gif " 
            )))));
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Image::class,
        ));
    }
  
}
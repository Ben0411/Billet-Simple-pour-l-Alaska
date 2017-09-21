<?php

namespace Form;

use Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('pseudo', TextType::class, array('constraints' => array(new Length(array(
                'min' => 2,
                'max' =>50,
                'minMessage' => 'Votre pseudo doit être composé au minimum de 2 caractères et au maximum 50 caractères',
                'maxMessage' => 'Votre pseudo doit être composé au minimum de 2 caractères et au maximum 50 caractères', 
            )))))
            ->add('comment', TextareaType::class, array('constraints' => array(new length(array(
                'min' => 10,
                'max' =>500,
                'minMessage' => 'Votre commentaire doit être composé au minimum de 10 caractères et au maximum 500 caractères',
                'maxMessage' => 'Votre commentaire doit être composé au minimum de 2 caractères et au maximum 500 caractères', 
            )))))
            ->add('save', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Comment::class,
        ));
    }
  
}
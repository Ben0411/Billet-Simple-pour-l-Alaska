<?php
namespace Form;

use Entity\Chapter;
use Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChapterType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class)
            ->add('number', NumberType::class, array( 'constraints' => array(new Range(array(
                'min' => 0,
                'max' => 900,
                'minMessage' => 'Vous devez entrer un nombre superieur à 0',
                'maxMessage' => 'Vous devez entrer un nombre inferieur à 900',
            )))))
            ->add('content', TextareaType::class)
            ->add('published',CheckboxType::class, array('required' => false))
            ->add('image', ImageType::class, array('required' => false,))
            ->add('save', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Chapter::class,
        ));
    }
}
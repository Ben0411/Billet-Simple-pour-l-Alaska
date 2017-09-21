<?php
namespace Form;

use Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class, array('constraints' => array(new Length(array(
                'min' => 3,
                'max' => 50,
                'minMessage' => '',
                'maxMessage' => '',
            )))))
            ->add('prenom', TextType::class, array('constraints' => array(new Length(array(
                'min' => 3,
                'max' => 50,
                'minMessage' => '',
                'maxMessage' => '',
            )))))
            ->add('mail', TextType::class, array('constraints' => array(new Email(array(
                'message' => "Cet email n'est pas un email valide",
            )))))
            ->add('sujet', TextType::class, array('constraints' => array(new Length(array(
                'min' => 10,
                'max' => 200,
                'minMessage' => '',
                'maxMessage' => '',
            )))))
            ->add('message', TextareaType::class, array('constraints' => array(new Length(array(
                'min' => 20,
                'max' => 5000,
                'minMessage' => '',
                'maxMessage' => '',
            )))))
            ->add('save', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
        ));
    }
}
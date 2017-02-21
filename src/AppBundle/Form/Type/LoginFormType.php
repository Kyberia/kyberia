<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('type', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'name' => 'name',
                    'id' => 'id',
                ],
                'data' => 'name',
            ])
            ->add('submit', SubmitType::class);
    }
}

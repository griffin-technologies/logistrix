<?php
/**
 * @author: Kieran <k.mckewen@griffin-tech.net>
 */

namespace LogistrixBundle\Form;


use LogistrixBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'           => PasswordType::class,
                    'label'          => false,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat password'],
                ]
            )->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) {
                    /** @var User $newUser */
                    $newUser = $event->getData();

                    if ($event->getForm()->isValid()) {
                        //Use email as username
                        $newUser->setUsername($newUser->getEmail());
                    }

                    $event->setData($newUser);
                }
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}

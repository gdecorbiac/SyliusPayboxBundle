<?php

namespace Gontran\SyliusPayboxBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PayboxGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.paybox.site',
                'constraints' => [
                    new NotBlank([
                        'message' => 'sylius.gateway_config.stripe.secret_key.not_blank',
                        'groups' => 'sylius',
                    ])
                ],
            ])
            ->add('rang', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.paybox.rank',
                'constraints' => [
                    new NotBlank([
                        'message' => 'sylius.gateway_config.stripe.secret_key.not_blank',
                        'groups' => 'sylius',
                    ])
                ],
            ])
            ->add('identifiant', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.paybox.identifier',
                'constraints' => [
                    new NotBlank([
                        'message' => 'sylius.gateway_config.stripe.secret_key.not_blank',
                        'groups' => 'sylius',
                    ])
                ],
            ])
            ->add('hmac', TextType::class, [
                'label' => 'sylius.form.gateway_configuration.paybox.hmac',
                'constraints' => [
                    new NotBlank([
                        'message' => 'sylius.gateway_config.stripe.secret_key.not_blank',
                        'groups' => 'sylius',
                    ])
                ],
            ])
            ->add('sandbox', CheckboxType::class, [
                'label' => 'sylius.form.gateway_configuration.paybox.sandbox',
                'required' => false,
            ])
        ;
    }
}

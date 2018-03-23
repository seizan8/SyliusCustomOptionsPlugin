<?php

declare(strict_types=1);

namespace Brille24\CustomerOptionsPlugin\Form\Validator;

use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionGroupInterface;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator\Constraint;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator\Validator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conditions', CollectionType::class, [
                'entry_type' => ConditionType::class,
                'entry_options' => [
                    'customerOptionGroup' => $options['customerOptionGroup'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'button_add_label' => 'brille24.form.validators.buttons.add_condition',
                'button_delete_label' => 'brille24.form.validators.buttons.delete_condition',
            ])
            ->add('constraints', CollectionType::class, [
                'entry_type' => ConditionType::class,
                'entry_options' => [
                    'data_class' => Constraint::class,
                    'customerOptionGroup' => $options['customerOptionGroup'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'button_add_label' => 'brille24.form.validators.buttons.add_constraint',
                'button_delete_label' => 'brille24.form.validators.buttons.delete_constraint',
            ])
            ->add('errorMessage', ErrorMessageType::class, [
                'label' => 'brille24.form.validators.error_message',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Validator::class,
        ]);

        $resolver->setDefined('customerOptionGroup');
        $resolver->setAllowedTypes('customerOptionGroup', CustomerOptionGroupInterface::class);
    }

    public function getBlockPrefix()
    {
        return 'brille24_customer_options_plugin_validator';
    }
}

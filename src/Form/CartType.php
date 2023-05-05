<?php

namespace App\Form;

use App\Entity\Product;
use App\Validator\TaxNumber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => fn (Product $product): string => $product->getName() . ' - €' . $product->getPrice(),
                'multiple' => true,
                'required' => true,
                'constraints' => [
                    new Count(min: 1),
                ]
            ])
            ->add('tax_number', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new TaxNumber(),
                ]
            ])
            ->add('Calculate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

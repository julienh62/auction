<?php

namespace App\Form;

use App\Entity\Auction;
use App\Entity\AuctionTranslation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('auction', EntityType::class, [
        'class' => AuctionTranslation::class,
        'choice_label' => 'title', // Remplacez par le nom de la propriété contenant les mots

                      'autocomplete' => true,
        ])
        ;
    }
}
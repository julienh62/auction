<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\TranslationField;
use App\Entity\Auction;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class AuctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Auction::class;
    }

// Define $fieldsConfig with the required properties for translation
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setFormThemes(
                [
                    '@A2lixTranslationForm/bootstrap_5_layout.html.twig',
                    '@EasyAdmin/crud/form_theme.html.twig',
                ]
            );
    }

    public function configureFields(string $pageName): iterable
    {

        $fieldsConfig = [
            'title' => [
                'field_type' => TextType::class,
                'required' => true,
                'label' => 'title'
            ],
            'description' => [
                'field_type' => TextType::class,
                'required' => true,
                'label' => 'description'
            ]
        ];
        return [
            TranslationField::new('translations', null, $fieldsConfig)
                ->setRequired(true)
                ->hideOnIndex(),
            DateField::new('DateOpen'),
            DateField::new('DateClose'),
            MoneyField::new('price')->setCurrency('EUR'),
            ChoiceField::new('status')
                ->setFormType(EnumType::class)
                ->setFormTypeOptions([
                    'class' => Status::class,
                    'choices' => Status::cases()
                ]),
            ImageField::new('image')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
                ->setRequired(true),
        ];
    }

}

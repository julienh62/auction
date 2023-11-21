<?php

namespace App\Controller\Admin;

use App\Entity\Auction;
use App\Entity\Product;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class AuctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Auction::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('description'),
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
                ->setRequired(true)
        ];
    }

}

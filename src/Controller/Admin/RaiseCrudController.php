<?php

namespace App\Controller\Admin;


use App\Entity\Raise;
use App\Enum\Status;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RaiseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Raise::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            DateField::new('createdAt'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('auction'), // Ajoutez ici le champ 'auction_id'
        ];
    }

}

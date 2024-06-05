<?php

namespace App\Controller\Admin;

use App\Entity\WsMembre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class WsMembreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WsMembre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Membre')
            ->setEntityLabelInPlural('Membres')
            ->renderContentMaximized()
            ->setSearchFields(['nom', 'prenom', 'email', 'section.name', 'section.unite.name', 'section.unite.groupe.name']);
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName || Crud::PAGE_DETAIL === $pageName) {
            return [
                TextField::new('nom', 'Nom'),
                TextField::new('prenom', 'Prénom'),
                EmailField::new('email', 'Email'),
                AssociationField::new('section')
                    ->formatValue(function ($value, $entity) {
                        return $entity->getSection()->getName();
                    }),
                    
                TextField::new('section.uniteName', 'Nom de l\'Unité')
                    ->formatValue(function ($value, $entity) {
                        return $entity->getSection()->getUniteName();
                    }),

                    TextField::new('section.groupeName', 'Nom du Groupe')
                    ->formatValue(function ($value, $entity) {
                        return $entity->getSection()->getGroupeName();
                    }),
                
            ];
        }
    
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            EmailField::new('email', 'Email')
          
        ];
    }
}

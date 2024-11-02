<?php

namespace App\Controller\Admin;

use App\Entity\Tuto;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextField, TextEditorField};
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class TutoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tuto::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $fields = [
            ImageField::new('image' , 'Image')
                ->setBasePath('/uploads/images/')
                ->setUploadDir('public/uploads/images/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];

        $slug = SlugField::new('slug')->setTargetFieldName('name');

        $name = TextField::new('name' , 'Titre')
            ->setFormTypeOptions([
                'attr' => [ 'maxlength' => 255 ]
            ]);

        $subtitle = TextField::new('subtitle' , 'Sous-titre')
            ->setFormTypeOptions([
                'attr' => [ 'maxlength' => 255 ]
            ]);
        $video = TextField::new('video' , 'Vidéo')
            ->setFormTypeOptions([
                'attr' => [ 'maxlength' => 255 ]
            ]);
        
        $link = TextField::new('link' , 'Lien')
            ->setFormTypeOptions([
                'attr' => [ 'maxlength' => 255 ]
            ]);

        $description = TextEditorField::new('description' , 'Description');

        $fields = [
            IdField::new('id')->hideOnForm(),
            $slug,
            $name,
            $subtitle,
            $video,
            $link,
            $description,
        ];
        
        return $fields;
    }
}

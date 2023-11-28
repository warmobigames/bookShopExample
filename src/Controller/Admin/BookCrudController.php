<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            ChoiceField::new('status')->setChoices([
                Book::BOOK_STATUS_DRAFT => Book::BOOK_STATUS_DRAFT,
                Book::BOOK_STATUS_PUBLISHED => Book::BOOK_STATUS_PUBLISHED,
                Book::BOOK_STATUS_STOPPED => Book::BOOK_STATUS_STOPPED,
                Book::BOOK_STATUS_FINISHED => Book::BOOK_STATUS_FINISHED,
            ]),
            ChoiceField::new('ageRestriction')->setChoices([
                Book::BOOK_AGE_RESTRICTION_ADULTS => Book::BOOK_AGE_RESTRICTION_ADULTS,
                Book::BOOK_AGE_RESTRICTION_CHILDREN => Book::BOOK_AGE_RESTRICTION_CHILDREN,
            ])
        ];
    }
}

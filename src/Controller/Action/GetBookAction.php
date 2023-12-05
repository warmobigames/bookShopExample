<?php

namespace App\Controller\Action;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetBookAction extends AbstractController
{
    public function __invoke(Book $book)
    {
        $book->setTitle('custom controller works!');
        return $book;
    }
}
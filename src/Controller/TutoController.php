<?php

namespace App\Controller;

use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $ProductRepository, int $id): Response
    {
        //$tuto = $entityManager->getRepository(Tuto::class)->find($id);
        $tuto = $ProductRepository->findOneById($id);

        if (!$tuto) {
            throw $this->createNotFoundException(
                'No tuto found for id '.$id
            );
        }
        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $tuto->getName(),
        ]);
    }

    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $product = new Tuto();
        $product->setName('unity');
        $product->setSlug('unity-tuto');
        $product->setDescription('lorem ipsum dolor sit amet');
        $product->setSubtitle('lorem ipsum dolor sit amet');
        $product->setImage('unity.jpg');
        $product->setVideo('watch?v=wzdCpJY6Y4c');
        $product->setLink('https://www.youtube.com/watch?v=wzdCpJY6Y4c');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}

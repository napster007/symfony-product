<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index', methods: ['GET'])]
    public function index(ProductRepository $repository): Response
    {
        $products = $repository->findAll();
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    #[Route('/products/{id<\d+>}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/products/new', name: 'product_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product;
       $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('notice', 'Product created successfully.');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/products/{id<\d+>}/edit', name: 'product_update')]
    public function update(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

       $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('notice', 'Product updated successfully.');

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/update.html.twig', [
            'form' => $form,
        ]);

    }

        // Handle the update logic (e.g., form submission)



    #[Route('/products/{id<\d+>}/delete', name: 'product_delete')]
    public function delete(Request $request, EntityManagerInterface $manager, Product $product): Response
    {
        if ($request->isMethod('POST')) {
            $manager->remove($product);
            $manager->flush();
            $this->addFlash('notice', 'Product deleted successfully.');
            return $this->redirectToRoute('product_index');
        }

       return $this->render('product/delete.html.twig', [
            'id' => $product->getId(),
        ]);
    }
    }

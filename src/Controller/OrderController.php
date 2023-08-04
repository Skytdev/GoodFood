<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use Error;
use App\Entity\Extra;
use App\Entity\Order;
use App\Entity\Customer;
use App\Entity\FactureRow;
use App\Entity\TicketRow;
use App\Repository\AddressRepository;
use App\Repository\MenuRepository;
use App\Repository\ProductRepository;
use App\Repository\CustomerRepository;
use App\Repository\FranchiseRepository;
use App\Repository\IngredientProductRepository;
use App\Repository\IngredientRepository;
use App\Repository\OrderStateRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{
  
    public function __invoke(Request $request, AddressRepository $addressRepository, FranchiseRepository $franchiseRepository, IngredientRepository $ingredientRepository, MenuRepository $menuRepository, OrderStateRepository $orderStateRepository, ProductRepository $productRepository, IngredientProductRepository $ingredientProductRepository, CustomerRepository $customerRepository)
    {
      if ($content = $request->getContent()) {
        $data = json_decode($content, false);
        $em = $this->getDoctrine()->getManager();
        $order = new Order();
        $em->persist($order);
        if (!property_exists($data, 'franchise') || !property_exists($data, 'address')) {
          throw new Error();
        } else {
          $order->setFranchise($franchiseRepository->find($data->franchise));
          $order->setAddress($addressRepository->find($data->address));
          $em->persist($order);
        }
        if (property_exists($data, 'menus') || property_exists($data, 'products')) {
          $order->setState($orderStateRepository->find(1));
          $order->setCustomer($this->getUser());
          $em->persist($order);
          foreach ($data->menus as $key => $menu) { // Boucle menus
            $menuObject = $menuRepository->find($menu->id);
            $factureRow = new FactureRow();
            $factureRow->setQuantity(1);
            $factureRow->setArticle($menuObject);
            $factureRow->setPrice($menuObject->getPrice());
            $factureRow->setOrderFinal($order);
            $em->persist($factureRow);
            $productsObjects = $menuObject->getProducts();
            foreach ($productsObjects as $key => $productObjet) {
              $orderRow = new TicketRow();
              $orderRow->setOrderFinal($order);
              $orderRow->setProduct($productObjet);
              $em->persist($orderRow);
            }

            foreach ($menu->products as $key => $product) { // Boucle produits des menus
              if (!$productsObjects->contains($productRepository->find($product->id))) {
                throw new Error();
              }
              if (property_exists($product, 'extras')) {
                foreach ($product->extras as $key => $extraIngredient) {
                  $ingredientProduct = $ingredientProductRepository->findOneBy(['product' => $product->id, 'ingredient' =>$extraIngredient->id ]);
                  if (is_null($ingredientProduct) || $ingredientProduct->getLimitQuantity() > $extraIngredient->quantity || !$ingredientProduct->getIsExtra()) {
                    throw new Error();
                  }
                  $ingredient = $ingredientRepository->find($extraIngredient->id);
                  $extra = new Extra();
                  $extra->setTicketRow($orderRow);
                  $extra->setIngredient($ingredient);
                  $extra->setQuantity($extraIngredient->quantity);
                  $em->persist($extra);
                  $factureRow = new FactureRow();
                  $factureRow->setQuantity(1);
                  $factureRow->setArticle($ingredient);
                  $factureRow->setPrice($ingredient->getExtraPrice());
                  $factureRow->setOrderFinal($order);
                  $em->persist($factureRow);
                }
              }
            }
          }
          foreach ($data->products as $key => $product) { // Boucle produits
            $orderRow = new TicketRow();
            $orderRow->setOrderFinal($order);
            $orderRow->setProduct($productRepository->find($product->id));
            $em->persist($orderRow);
            if (property_exists($product, 'extras')) {
              foreach ($product->extras as $key => $extraIngredient) {
                $ingredientProduct = $ingredientProductRepository->findOneBy(['product' => $product->id, 'ingredient' =>$extraIngredient->id ]);
                if (is_null($ingredientProduct) || $ingredientProduct->getLimitQuantity() < $extraIngredient->quantity || !$ingredientProduct->getIsExtra()) {
                  return new Response('', Response::HTTP_BAD_REQUEST);
                }
                $ingredient = $ingredientRepository->find($extraIngredient->id);
                $extra = new Extra();
                $extra->setTicketRow($orderRow);
                $extra->setIngredient($ingredient);
                $extra->setQuantity($extraIngredient->quantity);
                $em->persist($extra);
                $factureRow = new FactureRow();
                $factureRow->setQuantity(1);
                $factureRow->setArticle($ingredient);
                $factureRow->setPrice($ingredient->getExtraPrice());
                $factureRow->setOrderFinal($order);
                $em->persist($factureRow);
              }
            }
          }
          $em->flush();
        
          return new JsonResponse($order->getId());
        }
        else {
          return new Response('', Response::HTTP_BAD_REQUEST);
        }
      }
    }
}
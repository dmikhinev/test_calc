<?php

namespace App\Controller;

use App\Form\CartType;
use App\Repository\CountryRepository;
use App\Service\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product')]
    public function index(Request $request, CountryRepository $countryRepository, Calculator $calculator): Response
    {
        $total = null;
        $form = $this->createForm(CartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $country = $countryRepository->findOneBy(['code' => mb_substr($data['tax_number'], 0, 2)]); // я уверен что можно не делвть этот запрос а пробросить найденную страну из валидатора но быстро придумал только решения которые мне не нравятся

            $total = $calculator->calculate($country, $data['products']);
        }

        return $this->render('product/index.html.twig', [
            'cart_form' => $form,
            'total' => $total,
        ]);
    }
}

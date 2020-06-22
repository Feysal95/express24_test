<?php

namespace App\Controller;

use App\Entity\Currency;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/currencies", methods={"GET"}, name="get_currencies")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getCurrencies(Request $request)
    {
        $p = $request->get('p', 1);
        $limit = $request->get('limit', 40);
        $em = $this->getDoctrine()->getManager();

        $start = $p * $limit - $limit;
        $currencies = $em->getRepository(Currency::class)->findBy([], [], $limit, $start);

        return $this->json([
            'success' => true,
            'currencies' => $currencies
        ]);
    }

    /**
     * @Route("/currency/{id}", methods={"GET"}, name="get_currency_by_id")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getCurrencyById(Request $request)
    {
        $id = $request->get('id');
        $currency = $this->getDoctrine()->getRepository(Currency::class)->find($id);
        return $this->json([
            'success' => true,
            'currency' => $currency
        ]);
    }
}

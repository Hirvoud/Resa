<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Service\PriceCalculator;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->remove("numCommande");
        $form->remove("prixTotal");
        $form->remove("billets");
        $form->handleRequest($request);


        if($form->isSubmitted()) {

            $nbBillets = $commande->getNbBillets();

            for ($i = 1; $i <= $nbBillets; $i++) {
                $billet[$i] = new Billet();
                $commande->addBillet($billet[$i]);
            }

            $session = $request->getSession();

            $session->set("commande", $commande);

            return $this->redirectToRoute("select");
        }

        return $this->render('commande/index.html.twig', array(
            "form" => $form->createView(),
        ));
    }

    /**
     * @Route("/selection", name="select")
     */
    public function select(Request $request)
    {

        $commande = $request->getSession()->get("commande");

        $random = uniqid("clvr");

        $commande->setNumCommande($random);

        $commande->setPrixTotal(0);

        $orderForm = $this->createForm(CommandeType::class, $commande);
        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $session = $request->getSession();

            $commande = $orderForm->getData();

            $session->set("commande", $commande);

            return $this->redirectToRoute("confirm");
        }

        return $this->render("commande/select.html.twig", array(
            "orderForm" => $orderForm->createView(),
        ));
    }

    /**
     * @Route("/confirmation", name="confirm")
     */
    public function confirm(Request $request, PriceCalculator $calculator)
    {
        $commande = $request->getSession()->get("commande");

        $calculator->ageCheck($commande);

        return $this->render("commande/confirm.html.twig");
    }

}

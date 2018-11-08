<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\CommandeBilletsType;
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
            "orderForm" => $form->createView(),
        ));
    }

    /**
     * @Route("/selection", name="select")
     */
    public function select(Request $request)
    {

        $commande = $request->getSession()->get("commande");

        $random = uniqid();

        $commande->setNumCommande($random);

        dump($commande);

        $orderForm = $this->createForm(CommandeBilletsType::class, $commande);
        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $session = $request->getSession();

            $commande = $orderForm->getData();

            $session->set("commande", $commande);


            return $this->redirectToRoute("confirm");
        }

        return $this->render("commande/select.html.twig", array(
            "ticketForm" => $orderForm->createView(),
        ));
    }

    /**
     * @Route("/confirmation", name="confirm")
     */
    public function confirm(Request $request, PriceCalculator $calculator, ObjectManager $manager)
    {
        $commande = $request->getSession()->get("commande");

        $calculator->priceCheck($commande);
        //TODO renommer fonction ageCheck

        dump($commande);

        return $this->render("commande/confirm.html.twig", array(
            "tarif" => $commande->getPrixTotal()
        ));
    }

    /**
     * @Route("/paiement", name="pay")
     */
    public function pay()
    {
        return $this->render("commande/pay.html.twig");
    }

    /**
     * @Route("checkout", name="checkout")
     */
    public function checkout()
    {
        \Stripe\Stripe::setApiKey("sk_test_h4P4REIB1QPxd4do9NfhOn1h");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => 800, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Musée Louvre test - OC"
            ));
            $this->addFlash("success","Bravo ça marche !");
            return $this->redirectToRoute("pay");
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute("pay");
            // The card has been declined
        }
    }

}

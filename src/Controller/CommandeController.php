<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\CommandeBilletsType;
use App\Form\CommandeType;
use App\Service\Mailing;
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
        //$cManager = new CommandeManager();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //$cManager->CreationBillets($commande->getNbBillets());

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

        $date = $commande->getDateVisite();

        $limiteBillets = $this  ->getDoctrine()
                                ->getRepository(Commande::class)
                                ->countBilletsForDate($date);

        $random = strtoupper(uniqid());
        //TODO Construire un numéro de commande
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
    public function confirm(Request $request, PriceCalculator $calculator)
    {
        $session = $request->getSession();

        $commande = $session->get("commande");

        $calculator->priceCheck($commande);

        dump($commande);

        $session->set("commande", $commande);

        return $this->render("commande/confirm.html.twig", array(
            "prixTotal" => $commande->getPrixTotal(),
            "stripe_key" => $this->getParameter("stripe_public_key"),
            "email" => $commande->getEmail()
    ));
    }

    /**
     * @Route("/succes", name="success")
     */
    public function success(Request $request, ObjectManager $manager, Mailing $mailing)
    {
        $commande = $request->getSession()->get("commande");

        $manager->persist($commande);
        $manager->flush();

        $mailing->SendMail($commande);

        //TODO Mettre en forme le corps du mail
        return $this->render("commande/success.html.twig", array(
            "email" => $commande->getEmail()
        ));
    }

    /**
     * @Route("checkout", name="checkout")
     */
    public function checkout(Request $request)
    {
        $commande = $request->getSession()->get("commande");

        $prixTotal = $commande->getPrixTotal();

        \Stripe\Stripe::setApiKey($this->getParameter("stripe_private_key"));

        // Get the credit card details submitted by the form
        $token = $request->request->get('stripeToken');

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $prixTotal * 100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande n° " . $commande->getNumCommande() . "."
            ));

            return $this->redirectToRoute("success");
        } catch(\Stripe\Error\Card $e) {

            return $this->redirectToRoute("confirm");
            //return $this->redirectToRoute("error")
            // The card has been declined
        }
    }

}

<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\CommandeBilletsType;
use App\Form\CommandeType;
use App\Manager\CommandeManager;
use App\Service\Mailing;
use App\Service\Payment;
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
    public function home()
    {
        return $this->render("commande/index.html.twig");
    }

    /**
     * @Route("/billetterie", name="order")
     * @param Request $request
     * @param CommandeManager $commandeManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, CommandeManager $commandeManager)
    {
        $commande = $commandeManager->initCommande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commandeManager->creationBillets($commande);

            return $this->redirectToRoute("select");
        }

        return $this->render("commande/order.html.twig", array(
            "orderForm" => $form->createView(),
        ));
    }

    /**
     * @Route("/selection", name="select")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function select(Request $request, CommandeManager $commandeManager)
    {
        $commande = $commandeManager->getCurrentCommande();


        $orderForm = $this->createForm(CommandeBilletsType::class, $commande);
        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            $commandeManager->computePrice($commande);
            return $this->redirectToRoute("confirm");
        }

        return $this->render("commande/select.html.twig", array(
            "ticketForm" => $orderForm->createView(),
        ));
    }

    /**
     * @Route("/confirmation", name="confirm")
     */
    public function confirm(Request $request, CommandeManager $commandeManager)
    {
        $commande = $commandeManager->getCurrentCommande();

        dump($commande);

        return $this->render("commande/confirm.html.twig", array(
            "prixTotal" => $commande->getPrixTotal(),
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

        return $this->render("commande/success.html.twig", array(
            "email" => $commande->getEmail()
        ));
    }

    /**
     * @Route("checkout", name="checkout", methods={"POST"})
     */
    public function checkout(Request $request, Payment $payment)
    {
        $commande = $request->getSession()->get("commande");

        $checkout = $payment->Pay($commande);

        if ($checkout == true) {
            return $this->redirectToRoute("success");
        } else {
            //TODO Ajouter message flash
            return $this->redirectToRoute("confirm");
        }
    }

    /**
     * @Route("erreur", name="error")
     */
    public function error()
    {
        return $this->render("commande/error.html.twig");
    }

    /**
     * @Route("cancel", name="cancel")
     */
    public function cancel(Request $request)
    {
        $request->getSession()->clear();

        return $this->redirectToRoute("home");
    }
}

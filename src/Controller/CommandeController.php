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

        if($form->isSubmitted() && $form->isValid()) {

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

        dump($date);

        $limiteBillets = $this  ->getDoctrine()
                                ->getRepository(Commande::class)
                                ->findBy(
                                    ["dateVisite" => $date]
                    //TODO Affiner la recherche du nombre de billets en BDD
                                );

        dump($limiteBillets);

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
    public function confirm(Request $request, PriceCalculator $calculator)
    {
        $session = $request->getSession();

        $commande = $session->get("commande");

        $calculator->priceCheck($commande);

        dump($commande);

        $session->set("commande", $commande);

        return $this->render("commande/confirm.html.twig", array(
            "prixTotal" => $commande->getPrixTotal(),
            "stripe_key" => getenv("STRIPE_PK_KEY"),
            "email" => $commande->getEmail()
    ));
    }

    /**
     * @Route("/succes", name="success")
     */
    public function success()
    {
        return $this->render("commande/success.html.twig");
    }

    /**
     * @Route("checkout", name="checkout")
     */
    public function checkout(Request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {
        \Stripe\Stripe::setApiKey(getenv("STRIPE_SK_KEY"));

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        $session = $request->getSession();

        $commande = $session->get("commande");

        $prixTotal = $commande->getPrixTotal();

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $prixTotal * 100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Commande n° " . $commande->getNumCommande() . "."
            ));

            $manager->persist($commande);
            $manager->flush();

            $mail = (new \Swift_Message("Commande confirmée"))
                ->setFrom("jy.trsh@gmail.com")
                ->setTo("anfauglith@gmail.com")
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'commande/email.html.twig',
                        array("name" => $commande->getEmail(),
                            "number" => $commande->getNumCommande())
                    ),
                    'text/html'
                )
            ;

            $mailer->send($mail);

            return $this->redirectToRoute("success");
        } catch(\Stripe\Error\Card $e) {

            return $this->redirectToRoute("confirm");
            //return $this->redirectToRoute("error")
            // The card has been declined
        }
    }

}

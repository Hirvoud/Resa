<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\CommandeType;
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
        /*$commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);*/

        return $this->render('commande/index.html.twig'/*, array(
            "form" => $form->createView(),
        )*/);
    }

    /**
     * @Route("/selection", name="select")
     */
    public function select(Request $request, ObjectManager $manager)
    {
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["nbBillets"] = $_POST["nbBillets"];

        dump($_SESSION);

        $commande = new Commande();

        $billet1 = new Billet();
        $billet1->setNom("Ernest");
        $commande->addBillet($billet1);
        $billet2 = new Billet();
        $billet2->setNom("Pépito");
        $commande->addBillet($billet2);

        dump($commande);

        $manager->persist($commande);

        $orderForm = $this->createForm(CommandeType::class, $commande);
        $orderForm->handleRequest($request);

        return $this->render("commande/select.html.twig", array(
            "form" => $orderForm->createView(),
        ));
    }

}

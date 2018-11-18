<?php

namespace App\Service;


class Mailing
{
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $template)
    {
        $this->mailer   = $mailer;
        $this->template = $template;
    }

    public function SendMail($commande) {

        $mail = (new \Swift_Message("Musée du Louvre – Commande confirmée"))
            ->setFrom("jy.trsh@gmail.com")
            ->setTo($commande->getEmail())
            ->setBody(
                $this->template->render(
                    'commande/email.html.twig',
                    array(  "name" => $commande->getEmail(),
                            "numCom" => $commande->getNumCommande(),
                            "prixTotal" => $commande->getPrixTotal(),
                            "nbBillets" => $commande->getNbBillets()
                    )
                ),
                'text/html'
            )
        ;

        $this->mailer->send($mail);
    }
}
<?php

namespace App\Service;


use App\Entity\Commande;
use Swift_Image;

/**
 * @property \Twig_Environment template
 * @property \Swift_Mailer mailer
 */
class Mailing
{
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $template)
    {
        $this->mailer   = $mailer;
        $this->template = $template;
    }

    /**
     * @param Commande $commande
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function SendMail(Commande $commande) {

        $billets = $commande->getBillets();
        $image = "";

        $mail = (new \Swift_Message("Musée du Louvre – Commande confirmée"))
            ->setFrom("jy.trsh@gmail.com")
            ->setTo($commande->getEmail())
            ->setBody(
                $this->template->render(
                    "email/orderConfirm.html.twig",
                    array(  "commande" => $commande,
                            "billets" => $billets
                    )
                ),
                'text/html'
            )
        ;

        $this->mailer->send($mail);
    }
}
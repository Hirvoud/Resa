<?php

namespace App\Service;


use App\Entity\Commande;
use Swift_Image;
use Symfony\Component\HttpFoundation\Request;

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

        $mail = (new \Swift_Message("Musée du Louvre – Commande confirmée"));
        $url = $mail->embed(Swift_Image::fromPath('img/logo-louvre.png'));
        $mail
            ->setFrom("jy.trsh@gmail.com")
            ->setTo($commande->getEmail())
            ->setBody(
                $this->template->render(
                    "email/orderConfirm.html.twig",
                    array(  "commande" => $commande,
                            "billets" => $billets,
                            "urlImage" => $url
                    )
                ),

                'text/html'
            )
        ;

        $this->mailer->send($mail);
    }

    /**
     * @param Request $request
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function SendContactMail(Request $request)
    {
        $mail = (new \Swift_Message("Message en provenance d'un visiteur"))
            ->setFrom("jy.trsh@gmail.com")
            ->setTo("jy.trsh@gmail.com")
            ->setBody(
                $this->template->render(
                    "email/contact.html.twig",
                    array(  "nom" => $request->get("nom"),
                            "email" => $request->get("email"),
                            "contenu" => $request->get("content")
                    )
                ),
                "text/html"
            )
        ;

        $this->mailer->send($mail);
    }
}
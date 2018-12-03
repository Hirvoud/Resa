<?php

namespace App\Controller\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandeControllerTest extends WebTestCase
{
    public function testNewOrder()
    {
        $client = static::createClient();
        $crawler = $client->request("GET", "/");

        $link = $crawler->selectLink("Continuer")->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton("Enregistrer")->form();
        $form["commande[email]"] = "abc@xyz.def";
        $form["commande[dateVisite]"] = "2018-12-31";
        $form["commande[nbBillets]"] = "2";
        $form["commande[typeVisite]"] = "dj";

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter("html:contains('Sélection des billets')")->count());
        $this->assertSame(2, $crawler->filter("label:contains('Prénom')")->count());
        $this->assertSame(1, $crawler->filter("html:contains('Nom')")->count());
        $this->assertSame(1, $crawler->filter("html:contains('Date de naissance')")->count());

        $form = $crawler->selectButton("Valider")->form();
        $form["commande_billets[billets][0][prenom]"] = "Anatole";
        $form["commande_billets[billets][0][nom]"] = "Elotana";
        $form["commande_billets[billets][0][pays]"] = "France";
        $form["commande_billets[billets][0][dateNaissance][day]"] = "12";
        $form["commande_billets[billets][0][dateNaissance][month]"] = "4";
        $form["commande_billets[billets][0][dateNaissance][year]"] = "1980";
        $form["commande_billets[billets][0][reduit]"] = "1";

        $form["commande_billets[billets][1][prenom]"] = "Berthe";
        $form["commande_billets[billets][1][nom]"] = "Ehtreb";
        $form["commande_billets[billets][1][pays]"] = "Suisse";
        $form["commande_billets[billets][1][dateNaissance][day]"] = "21";
        $form["commande_billets[billets][1][dateNaissance][month]"] = "11";
        $form["commande_billets[billets][1][dateNaissance][year]"] = "1991";
        $form["commande_billets[billets][1][reduit]"] = "1";

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter("html:contains('Détail de votre commande')")->count());
        $this->assertSame(1, $crawler->filter("html:contains('paiement')")->count());
    }
}
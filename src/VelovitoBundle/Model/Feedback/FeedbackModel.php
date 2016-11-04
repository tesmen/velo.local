<?php

namespace VelovitoBundle\Model\Feedback;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use VelovitoBundle\C;
use VelovitoBundle\Entity\User;

/**
 * Class FeedbackModel
 * @package VelovitoBundle\Model\Social
 *
 * All targeted TO users actions FROM service
 */
class FeedbackModel
{
    public function __construct(EntityManager $em, \Swift_Mailer $mailer, TwigEngine $twigEngine, Router $router)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->templator = $twigEngine;
        $this->router = $router;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function sendGreeting(User $user = null)
    {
        $message = \Swift_Message::newInstance();
        $target = $user ? $user->getEmail() : 'tezmo@mail.ru';

        $body =
            $this->templator->render('@Velovito/email/greeting.html.twig', [
                'link' => $this->router->generate('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

        $message
            ->setSubject('Мы смогли!')
            ->setFrom('no-reply@velovito.ru')
            ->setTo($target)
            ->setBody($body, 'text/html');

        return $this->mailer->send($message);
    }
}

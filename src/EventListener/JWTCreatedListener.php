<?php

namespace App\EventListener;

use App\Entity\Customer;
use App\Entity\Employee;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Security
     */
    private $security;

    public function __construct(RequestStack $requestStack, Security $security)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload = $event->getData();
        $user = $event->getUser();
        if ($user instanceof Employee) {
            $payload['firstname'] = $user->getFirstname();
            $payload['lastname'] = $user->getLastname();
            $payload['birthday'] = $user->getBirthday()->format('c');
            $payload['civility'] = $user->getCivility();
            $payload['phone'] = $user->getPhone();
            $payload['id'] = $user->getId();
            if (!is_null($user->getFranchise())) {
                $payload['franchiseId'] = $user->getFranchise()->getId();
                $payload['franchiseName'] = $user->getFranchise()->getName();
            }
            $payload['type'] = 'Employee';
        } elseif ($user instanceof Customer) {
            $payload['firstname'] = $user->getFirstname();
            $payload['lastname'] = $user->getLastname();
            $payload['birthday'] = $user->getBirthday()->format('c');
            $payload['civility'] = $user->getCivility();
            $payload['phone'] = $user->getPhone();
            $payload['id'] = $user->getId();
            $payload['type'] = 'Customer';
        }

        $event->setData($payload);
    }
}

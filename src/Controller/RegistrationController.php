<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/api")
 * @IsGranted("PUBLIC_ACCESS")
 */
class RegistrationController extends AbstractController
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    /**
     * @Route("/employee/registration", name="registration_employee")
     */
    public function employee(Request $request)
    {
        $employee = new Employee();

        if ($content = $request->getContent()) {
            $parameters = json_decode($content, true);

            // Encode the new users password
            $employee->setPassword($this->hasher->hashPassword($employee, $parameters['password']));
            $employee->setEmail($parameters['email']);
            $employee->setFirstname($parameters['firstname']);
            $employee->setLastname($parameters['lastname']);
            $employee->setBirthday(\DateTime::createFromFormat('d/m/Y', $parameters['birthday']));
            // Set their role
            //$employee->setRoles(['ROLE_USER']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            return new Response('', Response::HTTP_CREATED);
        }
    }

    /**
     * @Route("/customer/registration", name="registration_customer")
     */
    public function customer(Request $request)
    {
        $customer = new Customer();

        if ($content = $request->getContent()) {
            $parameters = json_decode($content, true);

            // Encode the new users password
            $customer->setPassword($this->hasher->hashPassword($customer, $parameters['password']));
            $customer->setEmail($parameters['email']);
            $customer->setFirstname($parameters['firstname']);
            $customer->setLastname($parameters['lastname']);

            $customer->setBirthday(\DateTime::createFromFormat('d/m/Y', $parameters['birthday']));
            // Set their role
            //$customer->setRoles(['ROLE_USER']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return new Response('', Response::HTTP_CREATED);
        }
    }
}

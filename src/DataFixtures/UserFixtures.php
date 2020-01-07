<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    const DATA = [
        [
            "firstname" => "John",
            "lastname" => "DOE",
            "email" => "john@doe.com",
            "password" => "123456",
        ],
        [
            "firstname" => "Jane",
            "lastname" => "DOE",
            "email" => "jane@doe.com",
            "password" => "123456",
        ],
        [
            "firstname" => "Bob",
            "lastname" => "DOE",
            "email" => "bob@doe.com",
            "password" => "123456",
        ]
    ];

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        foreach (self::DATA as $data)
        {
            $user = new Users();
            $password = $this->encoder->encodePassword($user, $data['password']);

            $user->setFirstname( $data['firstname'] );
            $user->setLastname( $data['lastname'] );
            $user->setEmail( $data['email'] );
            $user->setPassword( $password );
            // $user->setIsActive( true );

            $this->setReference($data['email'], $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Username');
        $user->setEmail('user@mail.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
             $user,
             '1234'
        ));

        $adminUser = new User();
        $adminUser->setName('Admin');
        $adminUser->setEmail('admin@mail.com');
        $adminUser->setPassword($this->passwordEncoder->encodePassword(
            $adminUser,
            '1234'
        ));
        $adminUser->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));


        $manager->persist($user);
        $manager->persist($adminUser);
        $manager->flush();
    }
}

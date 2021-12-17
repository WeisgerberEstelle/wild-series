<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'email' => 'user1@mail;com',
            'password' => 'doe',
            'roles' => ['ROLE_CONTRIBUTOR']
        ],
        [
            'email' => 'user2@mail;com',
            'password' => 'smith',
            'roles' => ['ROLE_ADMIN']
        ],
    ];

    private UserPasswordHasherInterface $passwordHasher;


    public function __construct(UserPasswordHasherInterface $passwordHasher) 

    {

        $this->passwordHasher = $passwordHasher;

    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $key => $oneUser) {
            $user = new User();

            $user->setEmail($oneUser['email']);
            $user->setRoles($oneUser['roles']);

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $oneUser['password']
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }

        $manager->flush();
    }
}

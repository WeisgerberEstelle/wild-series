<?php

namespace App\DataFixtures;

use App\Entity\Actor;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    const ACTORS = ['Zach Braff', 'Donald Faison', 'Sarah Chalke', 'John C. McGinley', 'Judy Reyes', 'Neil Flynn', 'Andrew Lincoln', 'Norman Reedus',' Lauren Cohan', 'Danai Gurira','Cliff Curtis', 'Frank Dillane',' Maggie Grace', 'Colman Domingo', 'Lennie James', 'Jared Harris', 'Emily Watson', 'Jessies Buckley', 'Craig Mazin', 'David Dencik'];

    public function load(ObjectManager $manager): void
    {
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();

            $actor->setName($actorName);

            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        [
            'program' => 'program_0',
            'description' => 'Rick Grimes, shérif, est blessé à la suite d\'une course-poursuite. Il se retrouve dans le coma. Cependant, lorsqu\'il se réveille dans l\'hôpital, il ne découvre que désolation et cadavres. Se rendant vite compte qu\'il est seul, il décide d\'essayer de retrouver sa femme Lori et son fils Carl',
            'year' => 2010,
            'number' => 1,
        ],
        [
            'program' => 'program_1',
            'description' => 'le 26 avril 1986, une explosion secoue la centrale nucléaire soviétique Lénine et réveille la ville de Prypiat. Tant à l\'intérieur qu\'à l\'extérieur de la centrale, scientifiques, ingénieurs et habitants n\'ont aucune idée du drame qui se joue. ',
            'year' => 2019,
            'number' => 1,
        ],
        [
            'program' => 'program_3',
            'description' => 'A Los Angeles, Nick Clark, un jeune toxicomane qui accumule les problèmes, se réveille dans une église abandonnée et découvre son amie en train de dévorer la mâchoire d’un cadavre.',

            'year' => 2015,
            'number' => 1,
        ],
        [
            'program' => 'program_2',
            'description' => 'JD et Turk commencent leur internat à l\'hôpital du Sacré-cœur, le premier en médecine interne, le second en chirurgie. Ils rencontrent Elliot, une autre médecin dont JD tombe vite sous le charme, Carla, l\'infirmière en chef qui dirige le service de médecine d\'une main de fer, le Docteur Cox, médecin compétent mais arrogant, et Bob Kelso, le chef de médecine',
            'year' => 2001,
            'number' => 2,
        ],

        [
            'program' => 'program_4',
            'description' => 'Premier mois dans le développement les krakers partent en vrille',
            'year' => 2021,
            'number' => 1,
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $key => $show) {
            $season = new Season();

            $season->setprogram($this->getReference($show['program']));
            $season->setDescription($show['description']);
            $season->setYear($show['year']);
            $season->setNumber($show['number']);
            $manager->persist($season);
            $this->addReference('season_' . $key, $season);
        }

        $manager->flush();
    }

    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [

            ProgramFixtures::class

        ];
    }
}

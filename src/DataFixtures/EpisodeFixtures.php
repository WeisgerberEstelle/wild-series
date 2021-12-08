<?php

namespace App\DataFixtures;
use App\Service\Slugify;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    const EPISODES = [
        [
            'title' => 'Passé décomposé',
            'synopsis' => 'Rick Grimes, shérif, est blessé à la suite d\'une course-poursuite. Il se retrouve dans le coma. Cependant, lorsqu\'il se réveille dans l\'hôpital, il ne découvre que désolation et cadavres. Se rendant vite compte qu\'il est seul, il décide d\'essayer de retrouver sa femme Lori et son fils Carl',
            'season' => 'season_0',
            'number' => 1
        ],
        [
            'title' => 'Tripes',
            'synopsis' => 'Rick parvient à s\'échapper du tank grâce à l\'aide de Glenn, dont il avait entendu la voix à la radio. Rick et Glenn se réunissent avec les compagnons de Glenn, un autre groupe de survivants dont Andrea, T-dog, Merle, Morales, Jacqui, venus pour se ravitailler au supermarché.',
            'season' => 'season_0',
            'number' => 2
        ],
        [
            'title' => '1:23:45 ',
            'synopsis' => 'En avril 1986, une explosion dévastatrice dans la centrale nucléaire ukrainienne de Tchernobyl change la face du monde.',

            'season' => 'season_1',
            'number' => 1
        ],
        [
            'title' => 'Please Remain Calm',
            'synopsis' => 'La situation empire dans la centrale de Tchernobyl, et une autre explosion n\'est pas à exclure. Ulyana Khomyuk cherche à joindre Valery Legasov au plus vite pour l\'avertir du danger d\'une seconde déflagration. Dehors, les particules et les fumées radioactives se répandent rapidement dans l\'atmosphère. ',
            'season' => 'season_1',
            'number' => 2
        ],

        [
            'title' => 'Mon premier jour',
            'synopsis' => 'Le docteur John Dorian, alias J.D., démarre son premier jour à l\'Hôpital du Sacré-Cœur (Sacred Heart Hospital) après trois années d\'études en médecine. C\'est également le premier jour en tant que chirurgien de Chris Turk, le meilleur ami de J.D. Ils rencontrent une autre interne, Elliot Reid. Chris commence à flirter avec Carla une infirmière de l\'hôpital alors que J.D. rencontre Perry Cox un docteur cynique et sarcastique qui le fera paniquer.',
            'season' => 'season_3',
            'number' => 1
        ]
    ];

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }


    public function load(ObjectManager $manager): void
    {
        foreach (self::EPISODES as $key => $show) {
            $episode = new Episode();

            $episode->setTitle($show['title']);
            $episode->setSynopsis($show['synopsis']);
            $episode->setNumber($show['number']);
            $episode->setSeason($this->getReference($show['season']));
            $slug = $this->slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);
        }

        $manager->flush();
    }

    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [

            SeasonFixtures::class
        ];
    }
}

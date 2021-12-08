<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ActorFixtures;
use App\Service\Slugify;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'title' => 'The Walking Dead',
            'synopsis' => 'Après une apocalypse ayant transformé la quasi-totalité de la population en zombies, un groupe d\'hommes et de femmes mené par l\'officier Rick Grimes tente de survivre... Ensemble, ils vont devoir tant bien que mal faire face à ce nouveau monde devenu méconnaissable, à travers leur périple dans le Sud profond des États-Unis.',
            'category' => 'category_4',
            'actors' => ['actor_6', 'actor_7', 'actor_8', 'actor_9']
        ],
        [
            'title' => 'Chernobyl',
            'synopsis' => 'In April 1986, an explosion at the Chernobyl nuclear power plant in the Union of Soviet Socialist Republics becomes one of the world\'s worst man-made catastrophes.',
            'category' => 'category_1',
            'actors' => ['actor_16', 'actor_17', 'actor_18', 'actor_19']
        ],
        [
            'title' => 'Scrubs',
            'synopsis' => 'J.D., Turk et Elliot font leur internat de médecine à l\hôpital du Sacré Coeur. Ils y découvrent que la vie n\'y est pas facile et se retrouvent bien souvent dans des situations des plus loufoques.',

            'category' => 'category_2',
            'actors' => ['actor_0', 'actor_1', 'actor_2', 'actor_3', 'actor_4', 'actor_5']
        ],
        [
            'title' => 'Fear the walking Dead',
            'synopsis' => 'Madison est conseillère d’orientation dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et cumule les problèmes. Ils n’acceptent pas vraiment le nouveau compagnon de leur mère, Travis, professeur dans le même lycée et père divorcé d’un jeune adolescent. Autour de cette famille recomposée qui a du mal à recoller les morceaux, d’étranges comportements font leur apparition…',
            'category' => 'category_4',
            'actors' => ['actor_6', 'actor_10', 'actor_12', 'actor_13', 'actor_14']
        ],

        [
            'title' => 'Wilders en folie',
            'synopsis' => 'Les krakers de la WildCOdeSchool ont craqué!',
            'category' => 'category_1',
            'actors' => ['actor_1', 'actor_8', 'actor_12', 'actor_19', 'actor_2']
        ]
    ];

    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $key => $show) {
            $program = new Program();

            $program->setTitle($show['title']);
            $program->setSummary($show['synopsis']);
            $program->setCategory($this->getReference($show['category']));
            for ($i = 0; $i < count($show['actors']); $i++) {

                $program->addActor($this->getReference($show['actors'][$i]));
            }
            $slug = $this->slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }

        $manager->flush();
    }

    public function getDependencies()

    {

        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend

        return [

            ActorFixtures::class,

            CategoryFixtures::class,

        ];
    }
}

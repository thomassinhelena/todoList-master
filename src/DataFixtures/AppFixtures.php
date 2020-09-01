<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $status = new Status();
        $status->setLabel("En attente");
        $manager->persist($status);

        $status = new Status();
        $status->setLabel("A faire");
        $manager->persist($status);

        $status = new Status();
        $status->setLabel("En cours");
        $manager->persist($status);

        $status = new Status();
        $status->setLabel("Terminée");
        $manager->persist($status);

        $status = new Status();
        $status->setLabel("Cloturée");
        $manager->persist($status);

        $project = new Project();
        $project->setLabel("Module Constat");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Recrutement");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Module Devis");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Module Agenda");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Plate Forme");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("CRM client");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Administration");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Mobile Constat");
        $manager->persist($project);

        $project = new Project();
        $project->setLabel("Mobile Client");
        $manager->persist($project);

        $manager->flush();
    }
}

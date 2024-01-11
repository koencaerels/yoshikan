<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\YoshiKan\Infrastructure\CLI;

use App\YoshiKan\Domain\Model\Member\Federation;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\Gender;
use App\YoshiKan\Domain\Model\Member\Grade;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\Location;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\Member;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDummyMembers extends Command
{
    private readonly EntityManagerInterface $entityManager;
    private readonly MemberRepository $memberRepository;
    private readonly GradeRepository $gradeRepository;
    private readonly FederationRepository $federationRepository;
    private readonly LocationRepository $locationRepository;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('generate:members');

        $this->entityManager = $entityManager;
        $this->memberRepository = $entityManager->getRepository(Member::class);
        $this->gradeRepository = $entityManager->getRepository(Grade::class);
        $this->federationRepository = $entityManager->getRepository(Federation::class);
        $this->locationRepository = $entityManager->getRepository(Location::class);
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Executor
    // ——————————————————————————————————————————————————————————————————————————

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start generating members');
        $faker = Factory::create();
        $numberOfMembers = 40;

        // Grades random 1 tot en met 4
        // Sporta = ID 2 | Judo Vlaanderen = ID 1
        // location ID 1 to 4

        for ($i = 0; $i <= $numberOfMembers; ++$i) {
            $genderBit = rand(0, 1);
            if (0 === $genderBit) {
                $member = Member::make(
                    $this->memberRepository->nextIdentity(),
                    $faker->firstNameMale(),
                    $faker->lastName(),
                    new \DateTimeImmutable($faker->dateTimeThisCentury('now')->format('Y-m-d')),
                    Gender::M,
                    $this->gradeRepository->getById(rand(1, 4)),
                    $this->locationRepository->getById(rand(1, 4)),
                    $this->federationRepository->getById(rand(1, 2)),
                    $faker->email(),
                    $faker->isbn10(),
                    $faker->streetName(),
                    $faker->buildingNumber(),
                    '',
                    $faker->postcode(),
                    $faker->city,
                    rand(1, 3)
                );
            } else {
                $member = Member::make(
                    $this->memberRepository->nextIdentity(),
                    $faker->firstNameFemale(),
                    $faker->lastName(),
                    new \DateTimeImmutable($faker->dateTimeThisCentury('now')->format('Y-m-d')),
                    Gender::V,
                    $this->gradeRepository->getById(rand(1, 4)),
                    $this->locationRepository->getById(rand(1, 4)),
                    $this->federationRepository->getById(rand(1, 2)),
                    $faker->email(),
                    $faker->isbn10(),
                    $faker->streetName(),
                    $faker->buildingNumber(),
                    '',
                    $faker->postcode(),
                    $faker->city,
                    rand(1, 3)
                );
            }

            $startPeriodDate = $faker->dateTimeThisDecade('now');
            $startPeriod = $startPeriodDate->format('Y-m').'-01';
            $endPeriod = (intval($startPeriodDate->format('Y')) + 1).'-'.$startPeriodDate->format('m').'-01';
            $member->setSubscriptionDates(new \DateTimeImmutable($startPeriod), new \DateTimeImmutable($endPeriod), false);
            $member->setLicenseDates(new \DateTimeImmutable($startPeriod), new \DateTimeImmutable($endPeriod));

            // -- randomly mark as payed
            $payedBit = rand(0, 1);
            if (0 === $payedBit) {
                $member->markSubscriptionAsPayed();
                $member->markLicenseAsPayed();
            }

            // -- save the member to the database
            $this->memberRepository->save($member);
            $this->entityManager->flush();
            $output->write('.');
        }

        $output->writeln('Dummy members generated.');

        return 0;
    }
}

<?php

/*
 * This file is part of the Yoshi-Kan software.
 *
 * (c) Koen Caerels
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\YoshiKan\Application;

use App\YoshiKan\Application\Query\Member\GetConfigurationTrait;
use App\YoshiKan\Application\Query\Member\GetMemberTrait;
use App\YoshiKan\Application\Security\BasePermissionService;
use App\YoshiKan\Domain\Model\Member\FederationRepository;
use App\YoshiKan\Domain\Model\Member\GradeRepository;
use App\YoshiKan\Domain\Model\Member\GroupRepository;
use App\YoshiKan\Domain\Model\Member\LocationRepository;
use App\YoshiKan\Domain\Model\Member\MemberRepository;
use App\YoshiKan\Domain\Model\Member\PeriodRepository;
use App\YoshiKan\Domain\Model\Member\SettingsRepository;
use App\YoshiKan\Domain\Model\Member\SubscriptionRepository;
use App\YoshiKan\Domain\Model\Product\JudogiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;

class QueryBus
{
    use GetConfigurationTrait;
    use GetMemberTrait;

    protected BasePermissionService $permission;
    private const int ADMIN = 1;

    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(
        protected Security $security,
        protected EntityManagerInterface $entityManager,
        protected bool $isolationMode,
        protected Environment $twig,
        protected string $uploadFolder,
        protected GradeRepository $gradeRepository,
        protected GroupRepository $groupRepository,
        protected LocationRepository $locationRepository,
        protected MemberRepository $memberRepository,
        protected PeriodRepository $periodRepository,
        protected SettingsRepository $settingsRepository,
        protected SubscriptionRepository $subscriptionRepository,
        protected JudogiRepository $judogiRepository,
        protected FederationRepository $federationRepository
    ) {
        $this->permission = new BasePermissionService(
            $security->getUser(),
            $entityManager,
            $this->isolationMode
        );
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Output
    // ——————————————————————————————————————————————————————————————————————————

    public function helloFromQueryBus(): string
    {
        return 'hello from query bus';
    }
}

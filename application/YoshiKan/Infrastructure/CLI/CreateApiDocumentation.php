<?php

declare(strict_types=1);

namespace App\YoshiKan\Infrastructure\CLI;

use Nelmio\ApiDocBundle\ApiDocGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateApiDocumentation extends Command
{
    // ——————————————————————————————————————————————————————————————————————————
    // Constructor
    // ——————————————————————————————————————————————————————————————————————————

    public function __construct(/*private ApiDocGenerator $apiDocGenerator*/)
    {
        parent::__construct('openapi:gen');
    }

    // ——————————————————————————————————————————————————————————————————————————
    // Executor
    // ——————————————————————————————————————————————————————————————————————————

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $output->writeln('Start generating OpenAPI documentation');
//        $documentation = $this->apiDocGenerator->generate();
//        $json = json_encode($documentation, \JSON_PRETTY_PRINT);
//        $jsonPath = './frontends/member_module/src/api/client/schema.json';
//        file_put_contents($jsonPath, $json);
//        $output->writeln('Done generating OpenAPI documentation');
//
//        return Command::SUCCESS;
    }
}

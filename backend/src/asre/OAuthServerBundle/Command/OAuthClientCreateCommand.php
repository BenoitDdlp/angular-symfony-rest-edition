<?php
/**
 *
 * @author benoitddlp
 */
namespace asre\OAuthServerBundle\Command;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OAuthClientCreateCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('asre:oauth:client:create')
      ->setDescription('Creates a new client')
      ->addArgument('name', InputArgument::REQUIRED, 'Sets the client name', null)
      ->addOption('redirect-uri', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets redirect uri for client. Use this option multiple times to set multiple redirect URIs.', null)
      ->addOption('grant-type', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Sets allowed grant type for client. Use this option multiple times to set multiple grant types..', null)
      ->setHelp(<<<EOT
The %command.name% command creates a new client.

  php % command.full_name % [--redirect-uri =...] [--grant-type =...] name

EOT
      );
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    /** @var ClientManagerInterface $clientManager */
    $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
    /** @var \asre\OAuthServerBundle\Entity\Client $client */
    $client = $clientManager->createClient();
    $client->setName($input->getArgument('name'));
    $client->setRedirectUris($input->getOption('redirect-uri'));
    $client->setAllowedGrantTypes($input->getOption('grant-type'));
    $clientManager->updateClient($client);
    $output->writeln(sprintf('Added a new client with name <info>%s</info>, public id <info>%s</info> and secret <info>%s</info>.',
      $client->getName(),
      $client->getPublicId(),
      $client->getSecret()
    ));
  }
}
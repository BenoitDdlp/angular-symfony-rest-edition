<?php
namespace asre\RestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generic and extremely basic Symfony console command that merges translation files in src/<bundle>/Resources/translations/ directories
 * with translation files in the app/Resources/translations/ directory.
 *
 * Expected behaviour:
 *     1 - You have some translation files in src/<bundle>/Resources/translations/, but no translation files in app/Resources/translations/:
 *     ---- This command will create a copy of translation files in src/<bundle>/Resources/translations/ in app/Resources/translations/.
 *          Having translation files with identical filenames in multiple bundle folders will result in a merged copy, with duplicate key/value
 *          pairs being overwritten by one another.
 *
 *     2 - You have some translation files in src/<bundle>/Resources/translations/ as well as translation files in app/Resources/translations/:
 *     ---- This command will merge the translation files in app/Resources/translations/ with a copy of translation files in
 *          src/<bundle>/Resources/translations/. Key/value pairs from the translation files in app/Resources/translations/ will have priority,
 *          so no edited translations should be lost. The behaviour from (1) still applies.
 *
 * @author Kalman Olah <hello _AT_ kalmanolah _DOT_ net>
 */
class copyWsConfigCommand extends ContainerAwareCommand
{

  const LN_INFO = 'info';
  const LN_ERROR = 'error';
  const LN_COMMENT = 'comment';
  const LN_QUESTION = 'question';
  const DS = DIRECTORY_SEPARATOR;
  private $container;
  /** @var  InputInterface */
  private $input;
  /** @var  OutputInterface */
  private $output;
  private $toPath;
  private $serverBasePath;

  protected function configure()
  {
    $this
      ->setName('asre:wsconfig:copy')
      ->setDescription('copy ws config file from route asre_frontend_front_ws_config to [{--to-path} | asre-front/app/asre-scripts/js/ws-config.js]')
      ->addOption(
        'to-path',
        null,
        InputOption::VALUE_OPTIONAL,
        'Where to copy the web service file file ?',
        'asre-front/app/asre-scripts/js/ws-config.js'
      )
      ->addOption(
        'server-base-path',
        null,
        InputOption::VALUE_OPTIONAL,
        'Where to query the server ?',
        'http://localhost:8000'
      );
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->container = $this->getContainer();

    $this->input = $input;
    $this->output = $output;

    $this->toPath = $this->input->getOption('to-path');
    $this->serverBasePath = $this->input->getOption('server-base-path');

    $this->println("Copying to : " . $this->toPath, self::LN_COMMENT);
    $this->println("Server base path : " . $this->serverBasePath, self::LN_COMMENT);


    $this->performCommand();
  }

  private function println($string = '', $style = null, $indent = false)
  {
    if ($indent)
    {
      if (is_bool($indent))
      {
        $indent = 4;
      }
      $indenting = '';
      while ($indent > 0)
      {
        $indenting .= ' ';
        $indent--;
      }
      $string = $indenting . $string;
    }

    if ($style != null)
    {
      $string = '<' . $style . '>' . $string . '</' . $style . '>';
    }

    $this->output->writeln($string);
  }

  private function performCommand()
  {
    $wsConfig = $this->getContainer()->get('templating')->render('asreRestBundle:rest:ws-config.js.twig', array("serverBasePath" => $this->serverBasePath));

    if (true === $content = $this->writeFileContent($this->toPath, $wsConfig))
    {
      $this->println("Copied without errors.", self::LN_INFO);
      $this->println();
    }
    else
    {
      $this->println("Failed to copy ws config.", self::LN_ERROR);
      $this->println();
    }
  }

  private function writeFileContent($file, $content)
  {
    $fp = fopen($file, 'w');
    if (!$fp)
    {
      return false;
    }
    fwrite($fp, $content);
    if (!fclose($fp))
    {
      return false;
    }
    if (!chmod($file, 0777))
    {
      return false;
    }

    return true;
  }
}

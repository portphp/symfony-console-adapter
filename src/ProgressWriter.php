<?php

namespace Port\SymfonyConsole;

use Port\Reader\CountableReader;
use Port\Writer;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Writes output to the Symfony2 console
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class ProgressWriter implements Writer
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var ProgressBar
     */
    protected $progress;

    /**
     * @var string
     */
    protected $verbosity;

    /**
     * @var CountableReader
     */
    protected $reader;

    /**
     * @var integer
     */
    protected $redrawFrequency;

    /**
     * @param OutputInterface $output
     * @param CountableReader $reader
     * @param string          $verbosity
     * @param integer         $redrawFrequency
     */
    public function __construct(
        OutputInterface $output,
        CountableReader $reader,
        $verbosity = 'debug',
        $redrawFrequency = 1
    ) {
        $this->output           = $output;
        $this->reader           = $reader;
        $this->verbosity        = $verbosity;
        $this->redrawFrequency  = $redrawFrequency;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        $this->progress = new ProgressBar($this->output, $this->reader->count());
        $this->progress->setFormat($this->verbosity);
        $this->progress->setRedrawFrequency($this->redrawFrequency);
        $this->progress->start();
    }

    /**
     * {@inheritdoc}
     */
    public function writeItem(array $item)
    {
        $this->progress->advance();
    }

    /**
     * {@inheritdoc}
     */
    public function finish()
    {
        $this->progress->finish();
    }
}

<?php

namespace Inspector;

use Inspector\Iterator\Suspects;

use Symfony\Component\Finder\Finder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Inspector
{
    private $finder;
    private $dispatcher;

    /**
     * @param Finder $finder
     */
    public function __construct($finder, $dispatcher)
    {
        $this->setFinder($finder);
        $this->setDispatcher($dispatcher);
    }

    /**
     * Inspects a directory and selects files that match a needle.
     *
     * @param string $directory The absolute path to a directory
     * @param string $needle    The string or Regular Expression to match with the content
     *
     * @return Suspects The selected files
     */
    public function inspect($directory, $needle)
    {
        $this->getFinder()
            ->files()
            ->name('*')
            ->contains($needle)
            ->in($directory)
        ;

        $suspects = new Suspects();

        foreach ($this->getFinder() as $finder) {
            $suspects->append($finder);
        }

        return $suspects;
    }

    /**
     * @return Finder|null
     */
    public function getFinder()
    {
        return $this->finder;
    }

    /**
     * @param Finder $finder
     */
    public function setFinder(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
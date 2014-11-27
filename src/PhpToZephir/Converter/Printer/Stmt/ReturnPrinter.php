<?php

namespace PhpToZephir\Converter\Printer\Stmt;

use PhpToZephir\Converter\Dispatcher;
use PhpToZephir\Logger;
use PhpParser\Node\Stmt;
use PhpToZephir\converter\Manipulator\AssignManipulator;

class ReturnPrinter
{
    /**
     * @var Dispatcher
     */
    private $dispatcher = null;
    /**
     * @var Logger
     */
    private $logger = null;
    /**
     * @var AssignManipulator
     */
    private $assignManipulator = null;

    /**
     * @param Dispatcher $dispatcher
     * @param Logger $logger
     */
    public function __construct(Dispatcher $dispatcher, Logger $logger, AssignManipulator $assignManipulator)
    {
        $this->dispatcher = $dispatcher;
        $this->logger     = $logger;
        $this->assignManipulator = $assignManipulator;
    }

    public static function getType()
    {
        return "pStmt_Return";
    }

    public function convert(Stmt\Return_ $node) {
        $collected = $this->assignManipulator->collectAssignInCondition($node->expr);
        $node->expr = $this->assignManipulator->transformAssignInConditionTest($node->expr);

        return implode(";\n", $collected['extracted']) . "\n" .'return' . (null !== $node->expr ? ' ' . $this->dispatcher->p($node->expr) : '') . ';';
    }
}
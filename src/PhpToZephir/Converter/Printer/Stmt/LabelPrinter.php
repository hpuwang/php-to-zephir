<?php

namespace PhpToZephir\Converter\Printer\Stmt;

use PhpParser\Node\Stmt;
use PhpToZephir\Converter\SimplePrinter;

class LabelPrinter extends SimplePrinter
{
    public static function getType()
    {
        return "pStmt_Label";
    }

    public function convert(Stmt\Label $node)
    {
        $this->logger->trace(__METHOD__.' '.__LINE__, $node, $this->dispatcher->getMetadata()->getFullQualifiedNameClass());

        return $node->name.':';
    }
}

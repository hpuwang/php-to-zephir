<?php

namespace PhpToZephir\Converter\Printer\Stmt;

use PhpParser\Node\Stmt;
use PhpToZephir\Converter\SimplePrinter;

class ForPrinter extends SimplePrinter
{
    public static function getType()
    {
        return "pStmt_For";
    }

    public function convert(Stmt\For_ $node)
    {
        $this->logger->trace(__METHOD__.' '.__LINE__, $node, $this->dispatcher->getMetadata()->getFullQualifiedNameClass());

        return 'for '
             .$this->dispatcher->pCommaSeparated($node->init).';'.(!empty($node->cond) ? ' ' : '')
             .$this->dispatcher->pCommaSeparated($node->cond).';'.(!empty($node->loop) ? ' ' : '')
             .$this->dispatcher->pCommaSeparated($node->loop)
             .' {'.$this->dispatcher->pStmts($node->stmts)."\n".'}';
    }
}

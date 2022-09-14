<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedTraitsFixer;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
// use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    $ecsConfig->sets([
        SetList::PSR_12,
    ]);

    $ecsConfig->skip([
        // Skip class to class() x
        PhpCsFixer\Fixer\Operator\NewWithBracesFixer::class => [
            __DIR__ . '/database',
        ],
        PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer::class => [
            __DIR__ . '/database',
        ],
        PhpCsFixer\Fixer\Basic\BracesFixer::class => [
            __DIR__ . '/database',
        ],
        PhpCsFixer\Fixer\Basic\CurlyBracesPositionFixer::class => [
            __DIR__ . '/database',
        ]
    ]);

    /**
     * ADD CUSTOM RULE HERE
     */

    // Add declare(strict_types=1) on file header
    $ecsConfig->rule(DeclareStrictTypesFixer::class);

    // ordered_traits from php-cs-fixer
    $ecsConfig->rule(OrderedTraitsFixer::class);

    $ecsConfig->ruleWithConfiguration(ForbiddenFunctionsSniff::class, [
        'forbiddenFunctions' => [
            'dd' => null,
            'ddd' => null,
            'die' => null,
            'exit' => null,
            'eval' => null,
            'system' => null,
            'phpinfo' => null,
        ],
    ]);

    // POST
    // Remove unused import from file
    $ecsConfig->rule(NoUnusedImportsFixer::class);

    // Enforce to use space as indentation
    $ecsConfig->indentation(Option::INDENTATION_SPACES);

    // Run in parallel
    $ecsConfig->parallel();
};

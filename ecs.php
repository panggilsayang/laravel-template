<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\ClassNotation\{
    FinalClassFixer, OrderedTraitsFixer
};
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        __DIR__ . '/routes',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/tests',
    ]);

    // Skip final class on migrations
    $parameters->set(Option::SKIP, [
        FinalClassFixer::class => [
            __DIR__.'/database/migrations'
        ]
    ]);

    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::SYMFONY_RISKY);

    $services = $containerConfigurator->services();
    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);

    
    
    // PHP-CS-Fixer Rule
    $services->set(DeclareStrictTypesFixer::class); // 'declare_strict_types'
    $services->set(FinalClassFixer::class); // 'final_class'
    $services->set(OrderedTraitsFixer::class); // 'ordered_traits'

    // 'php_unit_method_casing' => ['case' => 'snake_case'],
    $services->set(PhpUnitMethodCasingFixer::class)
        ->call('configure', [[
            'case' => PhpUnitMethodCasingFixer::SNAKE_CASE
        ]]);

    $services->set(NoUnusedImportsFixer::class);


    // run and fix, one by one
    // $containerConfigurator->import(SetList::SPACES);
    // $containerConfigurator->import(SetList::ARRAY);
    // $containerConfigurator->import(SetList::DOCBLOCK);
};

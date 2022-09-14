<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ArrayShapeFromConstantArrayReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamAnnotationIncorrectNullableRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Rector\Visibility\Rector\ClassMethod\ExplicitPublicClassMethodRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/routes',
        __DIR__ . '/database',
        __DIR__ . '/tests',
    ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);
    $rectorConfig->rule(TypedPropertyRector::class);
    $rectorConfig->rule(AddArrayParamDocTypeRector::class);
    $rectorConfig->rule(AddClosureReturnTypeRector::class);
    $rectorConfig->rule(AddVoidReturnTypeWhereNoReturnRector::class);

    // Hard mode rector
    // $rectorConfig->rule(CallableThisArrayToAnonymousFunctionRector::class);

    // Laravel specific rule
    $rectorConfig->rule(\Rector\Laravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class);

    // Optional rule
    $rectorConfig->rule(SeparateMultiUseImportsRector::class);
    $rectorConfig->rule(SplitDoubleAssignRector::class);
    $rectorConfig->rule(SplitGroupedConstantsAndPropertiesRector::class);
    
    // Remove set TYPE_DECLARATION_STRICT to 1 by 1 rule
    // $rectorConfig->rule(ArrayShapeFromConstantArrayReturnRector::class);
    // $rectorConfig->rule(ParamAnnotationIncorrectNullableRector::class);
    // $rectorConfig->rule(ReturnTypeFromReturnNewRector::class);

    // Visibility
    $rectorConfig->rule(ExplicitPublicClassMethodRector::class);


    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_81,
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION_STRICT,
    ]);

    // post-changes:

    // Import long class to short class by 'use' keyword
    $rectorConfig->importNames();
};

<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\Persistence\Legacy\Tests\Filter\CriterionQueryBuilder\Location;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\Persistence\Legacy\Filter\CriterionQueryBuilder\Location\ParentLocationIdQueryBuilder;
use eZ\Publish\Core\Persistence\Legacy\Tests\Filter\BaseCriterionVisitorQueryBuilderTestCase;

/**
 * @covers \eZ\Publish\Core\Persistence\Legacy\Filter\CriterionQueryBuilder\Location\ParentLocationIdQueryBuilder::buildQueryConstraint
 * @covers \eZ\Publish\Core\Persistence\Legacy\Filter\CriterionQueryBuilder\Location\ParentLocationIdQueryBuilder::accepts
 */
final class ParentLocationQueryBuilderTest extends BaseCriterionVisitorQueryBuilderTestCase
{
    public function getFilteringCriteriaQueryData(): iterable
    {
        yield 'Parent Location ID=1' => [
            new Criterion\ParentLocationId(1),
            'location.parent_node_id IN (:dcValue1)',
            ['dcValue1' => [1]],
        ];

        yield 'Parent Location ID=1 OR Parent Location ID=2' => [
            new Criterion\LogicalOr(
                [
                    new Criterion\ParentLocationId(1),
                    new Criterion\ParentLocationId(2),
                ]
            ),
            '(location.parent_node_id IN (:dcValue1)) OR (location.parent_node_id IN (:dcValue2))',
            ['dcValue1' => [1], 'dcValue2' => [2]],
        ];
    }

    protected function getCriterionQueryBuilders(): iterable
    {
        return [new ParentLocationIdQueryBuilder()];
    }
}

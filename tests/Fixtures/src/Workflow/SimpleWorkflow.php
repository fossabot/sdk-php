<?php

/**
 * This file is part of Temporal package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Temporal\Tests\Workflow;

use Temporal\Activity\ActivityOptions;
use Temporal\Common\RetryOptions;
use Temporal\Workflow;
use Temporal\Workflow\WorkflowMethod;
use Temporal\Tests\Activity\SimpleActivity;

#[Workflow\WorkflowInterface]
class SimpleWorkflow
{
    #[WorkflowMethod(name: 'SimpleWorkflow')]
    public function handler(string $input)
    {
        $simple = Workflow::newActivityStub(
            SimpleActivity::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(5)
                ->withRetryOptions(
                    RetryOptions::new()->withMaximumAttempts(2)
                )
        );

        return yield $simple->echo($input);
    }
}

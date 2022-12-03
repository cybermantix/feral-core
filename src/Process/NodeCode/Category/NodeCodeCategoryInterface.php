<?php

namespace Nodez\Core\Process\NodeCode\Category;

/**
 * The NodeCode Category is a category organization object. The
 * categories describe the type of result that can come from
 * the process function.
 *
 * Examples:
 *   - flow / Flow / The NodeCode processes information in the context and results provide the
 *                   ability to direct the process flow.
 *
 *   - data / Data / The NodeCode processes and stores information into the context. The result of the process
 *                   indicates if data was processed and stored.
 *
 *   - work / Work / The NodeCode processes performs work on any internal or external service.
 */
interface NodeCodeCategoryInterface
{
    const FLOW = 'flow';

    const DATA = 'data';

    const WORK = 'work';

    /**
     * The key of the category which is lowercase alpha and underscores
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * The human friendly name of the category.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * A human friendly description that provides context to the admin.
     *
     * @return string
     */
    public function getDescription(): string;
}

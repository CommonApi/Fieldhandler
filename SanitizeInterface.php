<?php
/**
 * Sanitize Interface
 *
 * @package    Fieldhandler
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Fieldhandler;

use CommonApi\Exception\UnexpectedValueException;
use CommonApi\Fieldhandler\ValidateResponseInterface;

/**
 * Sanitize Interface
 *
 * @package    Fieldhandler
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
interface SanitizeInterface
{
    /**
     * Sanitize
     *
     * @param   string $field_name
     * @param   mixed  $field_value
     * @param   string $constraint
     * @param   array  $options
     *
     * @return  \CommonApi\Fieldhandler\ValidateResponseInterface
     * @since   1.0.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    public function sanitize($field_name, $field_value, $constraint, array $options = array());
}

<?php
/**
 * Fieldhandler Usage Trait
 *
 * @package    Fieldhandler
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace CommonApi\Fieldhandler;

use Exception;
use CommonApi\Exception\InvalidArgumentException;
use CommonApi\Exception\RuntimeException;

/**
 * Fieldhandler Usage Trait
 *
 * @package    Fieldhandler
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
trait FieldhandlerUsageTrait
{
    /**
     * Fieldhandler Instance
     *
     * @var    object  CommonApi\Fieldhandler\FieldhandlerInterface
     * @since  1.0.0
     */
    protected $fieldhandler;

    /**
     * Field Properties
     *
     * @var    array
     * @since  1.0.0
     */
    protected $field;

    /**
     * Method
     *
     * @var    string
     * @since  1.0.0
     */
    protected $method = null;

    /**
     * Field Name
     *
     * @var    string
     * @since  1.0.0
     */
    protected $field_name = null;

    /**
     * Field Value
     *
     * @var    string
     * @since  1.0.0
     */
    protected $field_value = null;

    /**
     * Field Type
     *
     * @var    string
     * @since  1.0.0
     */
    protected $field_type = null;

    /**
     * Messages
     *
     * @var    array
     * @since  1.0.0
     */
    protected $messages = array();

    /**
     * Process Field
     *
     * @param   string $method
     * @param   array  $field
     * @param   array  $options
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\InvalidArgumentException
     */
    protected function processField($method, array $field = array(), array $options = array())
    {
        $this->field  = $field;
        $this->method = strtolower($method);

        $this->editFieldhandlerMethod();

        foreach (array('name', 'value', 'type') as $key) {
            $this->editFieldhandlerAttribute($key);
        }

        $fieldhandler_results = $this->executeConstraint($options);

        $this->processConstraintResults($fieldhandler_results);

        return $this->field_value;
    }

    /**
     * Edit Method for Fieldhandler Method
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\InvalidArgumentException
     */
    protected function editFieldhandlerMethod()
    {
        if (in_array($this->method, array('validate', 'sanitize', 'format'))) {
            return $this;
        }

        throw new InvalidArgumentException(
            get_class($this)
            . ' passed in invalid Fieldhandler method '
            . $this->method
            . ' in FieldhandlerUsageTrait::editFieldhandlerMethod.'
        );
    }

    /**
     * Edit Fieldhandler Attribute
     *
     * @param   string $attribute
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\InvalidArgumentException
     */
    protected function editFieldhandlerAttribute($attribute)
    {
        $field_name = 'field_' . $attribute;

        $this->$field_name = null;

        if (isset($this->field[$attribute])) {
            $this->$field_name = $this->field[$attribute];

            return $this;
        }

        if ($attribute === 'value') {
            $this->$field_name = null;
            return $this;
        }

        throw new InvalidArgumentException(
            'No field ' . $attribute . ' passed into '
            . get_class($this)
            . ' FieldhandlerUsageTrait::editFieldhandlerAttribute '
        );
    }

    /**
     * Execute Fieldhandler Method
     *
     * @param   array $options
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function executeConstraint(array $options = array())
    {
        try {
            $method = $this->method;

            return $this->fieldhandler->$method(
                $this->field_name,
                $this->field_value,
                ucfirst(strtolower($this->field_type)),
                $options
            );

        } catch (Exception $e) {

            throw new RuntimeException (
                'FieldhandlerUsageTrait: executeConstraint method '
                . ' used within class '
                . get_class($this)
                . ' caught this exception: '
                . $e->getMessage()
            );
        }
    }

    /**
     * Process Fieldhandler Results
     *
     * @param   object  $fieldhandler_results
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    protected function processConstraintResults($fieldhandler_results)
    {
        $this->field_value = $fieldhandler_results->getFieldValue();

        return $this;
    }
}

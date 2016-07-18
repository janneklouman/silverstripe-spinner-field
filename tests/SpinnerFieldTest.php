<?php

/**
 * Tests for Spinner Field.
 *
 * @author     Janne Klouman <janne@klouman.com>
 * @license    https://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @package    spinnerfield
 * @subpackage tests
 */
class SpinnerFieldTest extends SapphireTest
{

    /**
     * Tests the 'min' option validation. It should restrain the value from being below
     * what the 'min' option is set to IF enforceBelowMinValidation is set to true
     * (which it is by default).
     *
     * @see {@link SpinnerField::$enforceBelowMinValidation}
     */
    public function testMinValidation()
    {
        
        // Validator
        $validator = Form::create(
            $this,
            'Form',
            FieldList::create(
                $spinnerField = SpinnerField::create('Spinner')
            ),
            FieldList::create()
        )->getValidator();

        // Test for value === -1 and min === 0 (should not be valid)
        $value = -1;
        $min   = 0;
        $spinnerField->setUIOption('min', $min);
        $spinnerField->setValue($value);
        $this->assertFalse(
            $spinnerField->validate($validator),
            'Validation has incorrectly passed for a field value of ' . $value
            . ' and a lower limit of ' . $min
            . ' with enforceBelowMinValidation set to true.'
        );

        // Test for value === 1 and min === 1 (should be valid)
        $value = 1;
        $min   = 1;
        $spinnerField->setUIOption('min', $min);
        $spinnerField->setValue($value);
        $this->assertTrue(
            $spinnerField->validate($validator),
            'Validation has incorrectly failed for a field value of ' . $value
            . ' and a lower limit of ' . $min
            . ' with enforceBelowMinValidation set to true.'
        );

        // Test for value === -1 and min === 0 with min validation turned off (should be valid)
        $value = -1;
        $min   = 0;
        $spinnerField = SpinnerField::create('Spinner');
        $spinnerField->setUIOption('min', $min);
        $spinnerField->setValue($value);
        $spinnerField->setEnforceBelowMinValidation(false);
        $this->assertTrue(
            $spinnerField->validate($validator),
            'Validation has incorrectly failed for a field value of ' . $value
            . ' and a lower limit of ' . $min
            . ' with enforceBelowMinValidation set to false.'
        );

    }

    /**
     * Tests the 'max' option validation. It should restrain the value from being above
     * what the 'max' option is set to -- IF enforceAboveMaxValidation is set to true
     * (which it is by default).
     *
     * @see {@link SpinnerField::$enforceAboveMaxValidation}
     */
    public function testMaxValidation()
    {

        // Validator
        $validator = Form::create(
            $this,
            'Form',
            FieldList::create(
                $spinnerField = SpinnerField::create('Spinner')
            ),
            FieldList::create()
        )->getValidator();

        // Test for value === 2 and max === 1 (should not be valid)
        $value = 2;
        $max   = 1;
        $spinnerField->setUIOption('max', $max);
        $spinnerField->setValue($value);
        $this->assertFalse(
            $spinnerField->validate($validator),
            'Validation has incorrectly passed for a field value of ' . $value
            . ' and an upper limit of ' . $max
            . ' with enforceAboveMaxValidation set to true.'
        );

        // Test for value === 1 and max === 1 (should be valid)
        $value = 1;
        $max   = 1;
        $spinnerField->setUIOption('max', $max);
        $spinnerField->setValue($value);
        $this->assertTrue(
            $spinnerField->validate($validator),
            'Validation has incorrectly failed for a field value of ' . $value
            . ' and an upper limit of ' . $max
            . ' with enforceAboveMaxValidation set to true.'
        );

        // Test for value === 4 and max === 2 with max validation turned off (should be valid)
        $value = 4;
        $max   = 2;
        $spinnerField->setUIOption('max', $max);
        $spinnerField->setValue($value);
        $spinnerField->setEnforceAboveMaxValidation(false);
        $this->assertTrue(
            $spinnerField->validate($validator),
            'Validation has incorrectly passed for a field value of ' . $value
            . ' and an upper limit of ' . $max
            . ' with enforceAboveMaxValidation set to false.'
        );

    }

    /**
     * Test step validation. It should restrain the value from not being evenly
     * divisible by the 'step' UI option -- IF enforceStepValidation is set to
     * true (which it isn't by default).
     *
     * @see {@Link SpinnerField::$enforceStepValidation}
     */
    public function testStepValidation()
    {

        // Validator
        $validator = Form::create(
            $this,
            'Form',
            FieldList::create(
                $spinnerField = SpinnerField::create('Spinner')
            ),
            FieldList::create()
        )->getValidator();

        // Test for value === 2 and step === 4 (should not be valid)
        $value = 2;
        $step  = 4;
        $spinnerField->setUIOption('step', $step);
        $spinnerField->setValue($value);
        $spinnerField->setEnforceStepValidation(true);
        $this->assertFalse(
            $spinnerField->validate($validator),
            'Validation has incorrectly passed for a field value of ' . $value
            . ' and step set to ' . $step
            . ' with enforceStepValidation set to true.'
        );

        // Test for value === 3 and step === 3 (should be valid)
        $value = 3;
        $step  = 3;
        $spinnerField->setUIOption('step', $step);
        $spinnerField->setValue($value);
        $this->assertTrue(
            $spinnerField->validate($validator),
            'Validation has incorrectly failed for a field value of ' . $value
            . ' and step set to ' . $step
            . ' with enforceStepValidation set to true.'
        );

        // Test for value === 2 and step === 5 with step validation turned off (should be valid)
        $value = 2;
        $step  = 5;
        $spinnerField->setUIOption('step', $step);
        $spinnerField->setValue($value);
        $spinnerField->setEnforceStepValidation(false);
        $this->assertTrue(
            $spinnerField->validate($validator),
            'Validation has incorrectly failed for a field value of ' . $value
            . ' and step set to ' . $step
            . ' with enforceStepValidation set to false.'
        );

    }

}
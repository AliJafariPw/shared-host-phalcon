<?php


namespace Phalcon\Mvc\Model\Validator;

use Phalcon\Mvc\EntityInterface;
use Phalcon\Mvc\Model\Validator;
use Phalcon\Mvc\Model\Exception;


/***
 * Phalcon\Mvc\Model\Validator\StringLength
 *
 * Simply validates specified string length constraints
 *
 * This validator is only for use with Phalcon\Mvc\Collection. If you are using
 * Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.
 *
 *<code>
 * use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
 *
 * class Subscriptors extends \Phalcon\Mvc\Collection
 * {
 *     public function validation()
 *     {
 *         $this->validate(
 *             new StringLengthValidator(
 *                 [
 *                     "field"          => "name_last",
 *                     "max"            => 50,
 *                     "min"            => 2,
 *                     "messageMaximum" => "We don't like really long names",
 *                     "messageMinimum" => "We want more than just their initials",
 *                 ]
 *             )
 *         );
 *
 *         if ($this->validationHasFailed() === true) {
 *             return false;
 *         }
 *     }
 * }
 *</code>
 *
 * @deprecated 3.1.0
 * @see Phalcon\Validation\Validator\StringLength
 **/

class StringLength extends Validator {

    /***
	 * Executes the validator
	 **/
    public function validate($record ) {

		$field = $this->getOption("field");
		if ( gettype($field) != "string" ) {
			throw new Exception("Field name must be a string");
		}

		/**
		 * At least one of 'min' or 'max' must be set
		 */
		$isSetMin = $this->isSetOption("min");
		$isSetMax = $this->isSetOption("max");

		if ( !isSetMin && !isSetMax ) {
			throw new Exception("A minimum or maximum must be set");
		}

		$value = record->readAttribute(field);

		if ( $this->isSetOption("allowEmpty") && empty value ) {
			return true;
		}

		/**
		 * Check if ( mbstring is available to calculate the correct length
		 */
		if ( function_exists("mb_strlen") ) {
			$length = mb_strlen(value);
		} else {
			$length = strlen(value);
		}

		/**
		 * Maximum length
		 */
		if ( isSetMax ) {

			$maximum = $this->getOption("max");
			if ( length > maximum ) {

				/**
				 * Check if ( the developer has defined a custom message
				 */
				$message = $this->getOption("messageMaximum");
				if ( empty message ) {
					$message = "Value of field ':field' exceeds the maximum :max characters";
				}

				this->appendMessage(strtr(message, [":field": field, ":max":  maximum]), field, "TooLong");
				return false;
			}
		}

		/**
		 * Minimum length
		 */
		if ( isSetMin ) {

			$minimum = $this->getOption("min");
			if ( length < minimum ) {

				/**
				 * Check if ( the developer has defined a custom message
				 */
				$message = $this->getOption("messageMinimum");
				if ( empty message ) {
					$message = "Value of field ':field' is less than the minimum :min characters";
				}

				this->appendMessage(strtr(message, [":field": field, ":min":  minimum]), field, "TooShort");
				return false;
			}
		}

		return true;
    }

}
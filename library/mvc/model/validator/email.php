<?php


namespace Phalcon\Mvc\Model\Validator;

use Phalcon\Mvc\EntityInterface;
use Phalcon\Mvc\Model\Exception;
use Phalcon\Mvc\Model\Validator;


/***
 * Phalcon\Mvc\Model\Validator\Email
 *
 * Allows to validate if email fields has correct values
 *
 * This validator is only for use with Phalcon\Mvc\Collection. If you are using
 * Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.
 *
 *<code>
 * use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
 *
 * class Subscriptors extends \Phalcon\Mvc\Collection
 * {
 *     public function validation()
 *     {
 *         $this->validate(
 *             new EmailValidator(
 *                 [
 *                     "field" => "electronic_mail",
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
 * @see Phalcon\Validation\Validator\Email
 **/

class Email extends Validator {

    /***
	 * Executes the validator
	 **/
    public function validate($record ) {

		$field = $this->getOption("field");
		if ( gettype($field) != "string" ) {
			throw new Exception("Field name must be a string");
		}

		$value = record->readAttribute(field);

		if ( $this->isSetOption("allowEmpty") && empty value ) {
			return true;
		}

		/**
		 * Filters the for (mat using FILTER_VALIDATE_EMAIL
		 */
		if ( !filter_var(value, FILTER_VALIDATE_EMAIL) ) {

			$message = $this->getOption("message");
			if ( empty message ) {
				$message = "Value of field ':field' must have a valid e-mail for (mat";
			}

			this->appendMessage(strtr(message, [":field": field]), field, "Email");
			return false;
		}

		return true;
    }

}
<?php


namespace Phalcon\Validation\Validator;

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;


/***
 * Phalcon\Validation\Validator\Regex
 *
 * Allows validate if the value of a field matches a regular expression
 *
 * <code>
 * use Phalcon\Validation;
 * use Phalcon\Validation\Validator\Regex as RegexValidator;
 *
 * $validator = new Validation();
 *
 * $validator->add(
 *     "created_at",
 *     new RegexValidator(
 *         [
 *             "pattern" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
 *             "message" => "The creation date is invalid",
 *         ]
 *     )
 * );
 *
 * $validator->add(
 *     [
 *         "created_at",
 *         "name",
 *     ],
 *     new RegexValidator(
 *         [
 *             "pattern" => [
 *                 "created_at" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
 *                 "name"       => "/^[a-z]$/",
 *             ],
 *             "message" => [
 *                 "created_at" => "The creation date is invalid",
 *                 "name"       => "The name is invalid",
 *             ]
 *         ]
 *     )
 * );
 * </code>
 **/

class Regex extends Validator {

    /***
	 * Executes the validation
	 **/
    public function validate($validation , $field ) {

		// Regular expression is set in the option 'pattern'
		// Check if ( the value match using preg_match in the PHP userland
		$matches = null;
		$value = validation->getValue(field);

		$pattern = $this->getOption("pattern");
		if ( gettype($pattern) == "array" ) {
			$pattern = pattern[field];
		}

		if ( preg_match(pattern, value, matches) ) {
			$failed = matches[0] != value;
		} else {
			$failed = true;
		}

		if ( failed === true ) {
			$label = $this->prepareLabel(validation, field),
				message = $this->prepareMessage(validation, field, "Regex"),
				code = $this->prepareCode(field);

			$replacePairs = [":field": label];

			validation->appendMessage(
				new Message(
					strtr(message, replacePairs),
					field,
					"Regex",
					code
				)
			);

			return false;
		}

		return true;
    }

}
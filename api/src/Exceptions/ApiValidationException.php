<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Class ApiValidationException
 * @package App\Exceptions
 */
class ApiValidationException extends Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    private $constraintViolationList;

    /**
     * ApiValidationException constructor.
     *
     * @param ConstraintViolationListInterface $constraintViolationList
     * @param string $message
     * @param integer $code
     * @param Throwable|null $previous
     */
    public function __construct(
        ConstraintViolationListInterface $constraintViolationList,
        $message = "",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->constraintViolationList = $constraintViolationList;
    }

    /**
     * Retorna os erros de validação
     *
     * @return array
     */
    public function getErrors(): array
    {
        $errors = [];

        if ($this->constraintViolationList->count() > 0) {
            /** @var ConstraintViolation $constraintViolation */
            foreach ($this->constraintViolationList as $constraintViolation) {
                $errors[] = $constraintViolation->getMessage();
            }
        }

        return $errors;
    }
}

<?php

namespace App\Validation;

use App\Exceptions\ApiValidationException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

/**
 * Class AbstractValidation
 * @package App\Validation
 */
abstract class AbstractValidation
{
    /**
     * Valida os dados da requisição
     *
     * @param array $content
     * @return void
     * @throws ApiValidationException
     */
    public function validate(array $content): void
    {
        $validator = Validation::createValidator();
        $violations = $validator->validate($content, $this->rules());

        if ($violations->count() > 0) {
            throw new ApiValidationException($violations);
        }
    }

    /**
     * As regras de validação
     *
     * @return Collection
     */
    abstract protected function rules(): Collection;
}

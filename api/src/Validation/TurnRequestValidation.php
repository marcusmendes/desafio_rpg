<?php

namespace App\Validation;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Positive;

/**
 * Class TurnRequestValidation
 * @package App\Validation
 */
class TurnRequestValidation extends AbstractValidation
{
    /**
     * As regras de validação
     *
     * @return Collection
     */
    protected function rules(): Collection
    {
        return new Collection([
            'round' => new Collection([
                'idRound' => [
                    new NotBlank(['message' => 'A propriedade [idRound] nao pode ser vazia.']),
                    new Positive(['message' => '[idRound] deve ser um numero positivo.'])
                ],
                'number' => [
                    new NotBlank(['message' => 'A propriedade [idRound] nao pode estar vazia.']),
                    new Positive(['message' => '[idRound] deve ser um numero positivo.'])
                ],
                'characters' => new Collection([
                    'human' => [
                        new NotBlank(['message' => 'A propriedade [human] nao pode ser vazia.']),
                        new Collection([
                            'uniqueId' => new NotBlank([
                                'message' => 'A propriedade [human uniqueId] nao pode ser vazia.'
                            ])
                        ])
                    ],
                    'orc' => [
                        new NotBlank(['message' => 'A propriedade [human] nao pode ser vazia.']),
                        new Collection([
                            'uniqueId' => new NotBlank([
                                'message' => 'A propriedade [orc uniqueId] nao pode ser vazia.'
                            ])
                        ])
                    ],
                ])
            ]),
            'turn' => new Collection([
                'step' => new NotBlank(['message' => 'A propriedade [step] nao pode ser vazia.']),
                'striker_uniqueId' => new Optional(),
                'defender_uniqueId' => new Optional()
            ])
        ]);
    }
}

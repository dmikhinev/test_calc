<?php

namespace App\Validator;

use App\Repository\CountryRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CountryRepository $countryRepository,
    ) {
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var TaxNumber $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $code = mb_substr($value, 0, 2);

        $country = $this->countryRepository->findOneBy(['code' => $code]);

        if (null !== $country
            && mb_strlen($value) === $country->getTaxNumberLength()
            && is_numeric(mb_substr($value, 2))
        ) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}

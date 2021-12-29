<?php

declare(strict_types=1);

namespace ArchiTools\Request;

use App\Shared\Infrastructure\Request\Exception\MissingRequestParameterException;
use ArchiTools\Exception\ValidationFailedException;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequestCommandResolver implements ArgumentValueResolverInterface
{
    protected SerializerInterface $serializer;
    protected ValidatorInterface $validator;
    protected LoggerInterface $logger;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    abstract public function supports(Request $request, ArgumentMetadata $argument): bool;

    /**
     * @throws ReflectionException
     * @throws MissingRequestParameterException
     * @throws \JsonException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $routeParams = $request->attributes->get('_route_params');
        $jsonContent = $request->getContent();

        $uriHasParams = isset($routeParams['id']) || isset($routeParams['type']);

        if ($uriHasParams) {
            $array = InformationSourceMerger::buildFromRequest($request);
            $jsonContent = json_encode($array, JSON_THROW_ON_ERROR);
        }

        PropertyChecker::checkProperties($argument->getType(), $request);

        $command = $this->serializer->deserialize($jsonContent, $argument->getType(), 'json');
        $errors = $this->getErrors($command);

        if (null !== $errors) {
            throw ValidationFailedException::create($errors);
        }

        yield $command;
    }

    protected function getErrors(object $command): array | null
    {
        $violationList = $this->validator->validate($command);

        if (0 === $violationList->count()) {
            return null;
        }

        $errors = [];

        /** @var ConstraintViolation $error */
        foreach ($violationList as $error) {
            $errors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $errors;
    }
}

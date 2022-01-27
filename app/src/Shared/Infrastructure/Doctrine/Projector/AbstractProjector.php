<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Projector;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class AbstractProjector implements EventSubscriberInterface
{
    /**
     * Returns list of events FQCN to be registered in Symfony domain event dispatcher.
     *
     * @return string[] Domain events class names
     */
    public static function getHandledEventsList(): array
    {
        return [];
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents(): array
    {
        $declaredEvents = static::getHandledEventsList();

        $subscribedEvents = [];

        foreach ($declaredEvents as $declaredEventName) {
            $declaredEventHandleMethod = self::getHandleMethod($declaredEventName);

            // skipping if method not found
            if (!method_exists(static::class, $declaredEventHandleMethod)) {
                continue;
            }

            $subscribedEvents[$declaredEventName] = $declaredEventHandleMethod;
        }

        return $subscribedEvents;
    }

    private static function getHandleMethod(string $event): string
    {
        $classParts = explode('\\', $event);

        return 'apply'.end($classParts);
    }
}

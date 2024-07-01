<?php

namespace App\EventSubscriber;

use App\Repository\ReservationRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private readonly UrlGeneratorInterface $router
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $setDataEvent)
    {
        $start = new \DateTime('2024-06-05 08:00:00');
        $end = new \DateTime('2024-06-30 17:00:00');
        // $start = $setDataEvent->getStart();
        // $end = $setDataEvent->getEnd();
        $filters = $setDataEvent->getFilters();

        $reservations = $this->reservationRepository->findReservationsBetweenDates($start, $end);

        // Modify the query to fit to your entity and needs
        // Change reservation.beginAt by your start date property
        // $reservations = $this->reservationRepository
        // ->createQueryBuilder('r')
        // ->where('r.startTime BETWEEN :start AND :end OR r.endTime BETWEEN :start AND :end')
        // ->setParameter('start', $start)
        // ->setParameter('end', $end)
        // ->getQuery()
        // ->getResult()
        // ;

        foreach ($reservations as $reservation) {
            // this create the events with your data (here reservation data) to fill calendar
            $reservationEvent = new Event(
                $reservation->getId(),
                $reservation->getStartTime(),
                $reservation->getEndTime() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             */
            $reservationEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $reservationEvent->addOption(
                'url',
                $this->router->generate('app_reservation_show', [
                    'id' => $reservation->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $setDataEvent->addEvent($reservationEvent);
        }
    }
}

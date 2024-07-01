<?php

namespace App\Form\Type;

use App\Entity\Connector;
use App\Entity\Person;
use App\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Person', EntityType::class, [
                'class' => Person::class,
                'choice_label' => function (Person $person): string {
                    return $person->getName();
                },
                'choice_value' => 'id',
            ])
            ->add('Connector', EntityType::class, [
                'class' => Connector::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                              ->where('u.inUse = :inUse')
                              ->setParameter('inUse', false);
                },
                'choice_label' => 'name',
            ])
            ->add('StartTime', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'hours' => range(8, 17),
                'minutes' => range(0, 59, 30),
                'data' => new \DateTime(),
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d H:i:s'), // Ensuring the minimum date is today
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}

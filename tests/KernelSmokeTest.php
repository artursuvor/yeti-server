<?php

namespace App\Tests;

use App\Controller\ReviewController;
use App\Controller\SecurityController;
use App\Controller\YetiController;
use App\Exception\ReviewException;
use App\Object\Review;
use App\Object\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class KernelSmokeTest extends KernelTestCase
{
    public function testApplicationBootsAndControllersCanBeAutowired(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        foreach ([YetiController::class, ReviewController::class, SecurityController::class] as $controller) {
            self::assertInstanceOf($controller, $container->get($controller));
        }
        self::assertNotNull($container->get('router')->getRouteCollection()->get('yeti_list'));
    }

    public function testDomainObjectsAndExceptionsAreAutoloadable(): void
    {
        $review = Review::createFromArray(['yeti_id' => 7, 'comment' => 'Example', 'rating' => 5]);
        self::assertSame(['yetiId' => 7, 'comment' => 'Example', 'rating' => 5], $review->toArray());
        $user = new User(1, 'example', password_hash('test-password', PASSWORD_BCRYPT, ['cost' => 4]));
        self::assertTrue($user->verifyPassword('test-password'));
        self::assertFalse($user->verifyPassword('incorrect'));
        self::assertInstanceOf(\Exception::class, new ReviewException('Example'));
    }
}

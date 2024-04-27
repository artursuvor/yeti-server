<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use App\Repository\ReviewRepository;
use ReviewException;
use Review;

class ReviewController extends AbstractController
{
    public function __construct(
        private Connection $connection,
        private ReviewRepository $reviewRepository,
    ) {
    }

    #[Route('review/get_all_for_yeti/{yeti_id}', name: 'get_yeti_reviews')]
    public function getYetiReviewsAction(int $yeti_id): Response
    {
      $reviews = $this->reviewRepository->getAllReviewsByYetiId($yeti_id);

      if ($reviews === []) {
          throw $this->createNotFoundException('Review for Yeti with id ' . $yeti_id . ' does not exist.');
      }

      $reviews = array_map(fn(Review $review) => $review->toArray(), $reviews);
      $response = new Response(json_encode($reviews));
      $response->headers->set('Content-Type', 'application/json');
      $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');

      return $response;
    }

    #[Route('review/addReview', name: 'add_review', methods: ['POST'])]
    public function addReviewAction(Request $request): Response
    {
      $data = json_decode($request->getContent(), true);

      $review = new Review(
        yetiId: $data['yetiId'],
        comment: $data['comment'],
        rating: $data['rating'],
      );

      try {
          $this->reviewRepository->addReview($review);
      } catch (ReviewException $e) {
          return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
      }

      return new Response('Review added!', Response::HTTP_OK);
    }
}

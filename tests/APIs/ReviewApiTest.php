<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Review;

class ReviewApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_review()
    {
        $review = Review::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/reviews', $review
        );

        $this->assertApiResponse($review);
    }

    /**
     * @test
     */
    public function test_read_review()
    {
        $review = Review::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/reviews/'.$review->id
        );

        $this->assertApiResponse($review->toArray());
    }

    /**
     * @test
     */
    public function test_update_review()
    {
        $review = Review::factory()->create();
        $editedReview = Review::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/reviews/'.$review->id,
            $editedReview
        );

        $this->assertApiResponse($editedReview);
    }

    /**
     * @test
     */
    public function test_delete_review()
    {
        $review = Review::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/reviews/'.$review->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/reviews/'.$review->id
        );

        $this->response->assertStatus(404);
    }
}

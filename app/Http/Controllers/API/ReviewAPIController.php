<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReviewAPIRequest;
use App\Http\Requests\API\UpdateReviewAPIRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ReviewResource;

/**
 * Class ReviewController
 */

class ReviewAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/reviews",
     *      summary="getReviewList",
     *      tags={"Review"},
     *      description="Get all Reviews",
     *      security={ {"sanctum": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Review")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Review::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $reviews = $query->get();

        return $this->sendResponse(ReviewResource::collection($reviews), 'Reviews retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/reviews",
     *      summary="createReview",
     *      tags={"Review"},
     *      description="Create Review",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Review")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Review"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReviewAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Review $review */
        $review = Review::create($input);

        return $this->sendResponse(new ReviewResource($review), 'Review saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/reviews/{id}",
     *      summary="getReviewItem",
     *      tags={"Review"},
     *      description="Get Review",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Review",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Review"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Review $review */
        $review = Review::find($id);

        if (empty($review)) {
            return $this->sendError('Review not found');
        }

        return $this->sendResponse(new ReviewResource($review), 'Review retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/reviews/{id}",
     *      summary="updateReview",
     *      tags={"Review"},
     *      description="Update Review",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Review",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Review")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Review"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReviewAPIRequest $request): JsonResponse
    {
        /** @var Review $review */
        $review = Review::find($id);

        if (empty($review)) {
            return $this->sendError('Review not found');
        }

        $review->fill($request->all());
        $review->save();

        return $this->sendResponse(new ReviewResource($review), 'Review updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/reviews/{id}",
     *      summary="deleteReview",
     *      tags={"Review"},
     *      description="Delete Review",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Review",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Review $review */
        $review = Review::find($id);

        if (empty($review)) {
            return $this->sendError('Review not found');
        }

        $review->delete();

        return $this->sendSuccess('Review deleted successfully');
    }
}

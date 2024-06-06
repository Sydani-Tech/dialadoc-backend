<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTestResultAPIRequest;
use App\Http\Requests\API\UpdateTestResultAPIRequest;
use App\Models\TestResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TestResultResource;

/**
 * Class TestResultController
 */

class TestResultAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/test-results",
     *      summary="getTestResultList",
     *      tags={"TestResult"},
     *      description="Get all TestResults",
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
     *                  @OA\Items(ref="#/components/schemas/TestResult")
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
        $query = TestResult::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $testResults = $query->get();

        return $this->sendResponse(TestResultResource::collection($testResults), 'Test Results retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/test-results",
     *      summary="createTestResult",
     *      tags={"TestResult"},
     *      description="Create TestResult",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TestResult")
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
     *                  ref="#/components/schemas/TestResult"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTestResultAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TestResult $testResult */
        $testResult = TestResult::create($input);

        return $this->sendResponse(new TestResultResource($testResult), 'Test Result saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/test-results/{id}",
     *      summary="getTestResultItem",
     *      tags={"TestResult"},
     *      description="Get TestResult",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TestResult",
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
     *                  ref="#/components/schemas/TestResult"
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
        /** @var TestResult $testResult */
        $testResult = TestResult::find($id);

        if (empty($testResult)) {
            return $this->sendError('Test Result not found');
        }

        return $this->sendResponse(new TestResultResource($testResult), 'Test Result retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/test-results/{id}",
     *      summary="updateTestResult",
     *      tags={"TestResult"},
     *      description="Update TestResult",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TestResult",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TestResult")
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
     *                  ref="#/components/schemas/TestResult"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTestResultAPIRequest $request): JsonResponse
    {
        /** @var TestResult $testResult */
        $testResult = TestResult::find($id);

        if (empty($testResult)) {
            return $this->sendError('Test Result not found');
        }

        $testResult->fill($request->all());
        $testResult->save();

        return $this->sendResponse(new TestResultResource($testResult), 'TestResult updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/test-results/{id}",
     *      summary="deleteTestResult",
     *      tags={"TestResult"},
     *      description="Delete TestResult",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TestResult",
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
        /** @var TestResult $testResult */
        $testResult = TestResult::find($id);

        if (empty($testResult)) {
            return $this->sendError('Test Result not found');
        }

        $testResult->delete();

        return $this->sendSuccess('Test Result deleted successfully');
    }
}

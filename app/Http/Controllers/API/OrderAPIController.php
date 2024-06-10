<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOrderAPIRequest;
use App\Http\Requests\API\UpdateOrderAPIRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\OrderResource;

/**
 * Class OrderController
 */

class OrderAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/orders",
     *      summary="getOrderList",
     *      tags={"Order"},
     *      description="Get all Orders",
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
     *                  @OA\Items(ref="#/components/schemas/Order")
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
        $query = Order::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $orders = $query->get();

        return $this->sendResponse(OrderResource::collection($orders), 'Orders retrieved successfully');
    }


    /**
     * @OA\Get(
     *      path="/orders/{id}",
     *      summary="getOrderItem",
     *      tags={"Order"},
     *      description="Get Order",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Order",
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
     *                  ref="#/components/schemas/Order"
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
        /** @var Order $order */
        $order = Order::find($id);

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        return $this->sendResponse(new OrderResource($order), 'Order retrieved successfully');
    }

    public function makePayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'order_type' => 'required|string|in:appointment,pharmacy',
            'amount' => 'required|numeric'
        ]);


    }
}

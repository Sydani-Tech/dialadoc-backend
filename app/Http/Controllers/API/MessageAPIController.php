<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMessageAPIRequest;
use App\Http\Requests\API\UpdateMessageAPIRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\MessageResource;

/**
 * Class MessageController
 */

class MessageAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/messages",
     *      summary="getMessageList",
     *      tags={"Message"},
     *      description="Get all Messages",
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
     *                  @OA\Items(ref="#/components/schemas/Message")
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
        $query = Message::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $messages = $query->get();

        return $this->sendResponse(MessageResource::collection($messages), 'Messages retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/messages",
     *      summary="createMessage",
     *      tags={"Message"},
     *      description="Create Message",
     *      security={ {"sanctum": {} }},
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Message")
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
     *                  ref="#/components/schemas/Message"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMessageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Message $message */
        $message = Message::create($input);

        return $this->sendResponse(new MessageResource($message), 'Message saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/messages/{id}",
     *      summary="getMessageItem",
     *      tags={"Message"},
     *      description="Get Message",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Message",
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
     *                  ref="#/components/schemas/Message"
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
        /** @var Message $message */
        $message = Message::find($id);

        if (empty($message)) {
            return $this->sendError('Message not found');
        }

        return $this->sendResponse(new MessageResource($message), 'Message retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/messages/{id}",
     *      summary="updateMessage",
     *      tags={"Message"},
     *      description="Update Message",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Message",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Message")
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
     *                  ref="#/components/schemas/Message"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMessageAPIRequest $request): JsonResponse
    {
        /** @var Message $message */
        $message = Message::find($id);

        if (empty($message)) {
            return $this->sendError('Message not found');
        }

        $message->fill($request->all());
        $message->save();

        return $this->sendResponse(new MessageResource($message), 'Message updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/messages/{id}",
     *      summary="deleteMessage",
     *      tags={"Message"},
     *      description="Delete Message",
     *      security={ {"sanctum": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Message",
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
        /** @var Message $message */
        $message = Message::find($id);

        if (empty($message)) {
            return $this->sendError('Message not found');
        }

        $message->delete();

        return $this->sendSuccess('Message deleted successfully');
    }
}

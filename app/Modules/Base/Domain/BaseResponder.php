<?php

namespace App\Modules\Base\Domain;

use App\Modules\Common\Domain\Payload;
use Illuminate\Support\{Str, Arr};
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponder
{
    protected $request;
    protected $response;
    protected $payload;

    public function __invoke(Payload $payload): Response
    {
        $this->payload = $payload;
        $method = $this->getMethodForPayload();
        $this->$method();
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/response.log'),
        ])->info(json_encode($this->payload->getResult()));
        return $this->response;
    }

    /*
    * DATA STATUS
    */

    protected function found(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Get Data Successfully !!',
            'data'      => $this->payload->getResult()['data']
        ]);
    }

    protected function created(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Create succesfully !!',
            'data'      => $this->payload->getResult()['create']
        ]);
    }

    protected function updated(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Update succesfully !!',
            'data'      => $this->payload->getResult()['update']
        ]);
    }

    protected function deleted(): void
    {
        $this->renderResult();
    }

    protected function restored(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Restore succesfully !!'
        ]);
    }

    protected function notValid(): void
    {
        $this->response = response()
            ->json([
                'status'    => false,
                'messages'  => $this->payload->getResult()['messages'],
                'data'      => Arr::except($this->payload->getResult()['data'], '_method')
            ], 400);
    }

    protected function notFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'ID : ' . $this->payload->getResult()['id'] . ' not found !!'
            ], 404)
        );
    }
    protected function eventNotFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Event-ID : ' . $this->payload->getResult()['event_id'] . ' not found !!'
            ], 404)
        );
    }
    protected function noActiveEvent(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'No active event, please create or activate one'
            ], 400)
        );
    }
    protected function slugNotFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Slug : ' . $this->payload->getResult()['slug'] . ' not found !!'
            ], 404)
        );
    }
    protected function assetNotFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Asset : ' . $this->payload->getResult()['asset'] . ' not found !!'
            ], 404)
        );
    }

    /*
    * OTHER STATUS
    */
    protected function unauthorized(): void
    {
        $this->response = abort(response()->json(['messages' => 'Unauthorized']));
    }
    protected function forbidden(): void
    {
        $this->response = abort(response()->json(['messages' => 'Forbidden'], 403));
    }
    protected function notOwner(): void
    {
        $this->response = abort(
            response()->json(
                [
                    'status' => false,
                    'messages' => 'Cant modify, You are not own this resource'
                ],
                403
            )
        );
    }
    protected function protectedResource(): void
    {
        $this->response = abort(response()->json(['messages' => 'Cant modify protected resource'], 403));
    }

    protected function error(): void
    {
        $e = $this->payload->getResult()['exception'];
        $this->response = abort(
            response()->json($e, 505)
        );
    }

    protected function renderResult(): void
    {
        $this->response = response()->json($this->payload->getResult());
    }

    protected function getMethodForPayload(): string
    {
        $method = Str::camel($this->payload->getStatus());
        return method_exists($this, $method) ? $method : 'notRecognized';
    }

    protected function notRecognized(): void
    {
        $domain_status = $this->payload->getStatus();
        $this->response = abort(501, sprintf('Unknown method (%s) for payload status: \'%s\'', Str::camel($domain_status), $domain_status));
    }

    protected function noData(): void
    {
        $this->response = abort(response()->json([], 204));
    }

    protected function downloadAndRemove(): void
    {
        $this->response = response()->download(
            public_path(
                'storage/' . $this->payload->getResult()['path']
            )
        )->deleteFileAfterSend();
    }

    protected function expired(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messsages' => 'Expired'
        ], 410);
    }

    protected function hasRecord(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messsages' => 'Cant perform this action, already have an record'
        ], 409);
    }
    /**
     * Password confirmation
     */
    protected function passwordConfirmTrue(): void
    {
        $this->response = response()->json([
            'status' => true
        ], 204);
    }
    protected function passwordConfirmFalse(): void
    {
        $this->response = response()->json([
            'status' => false,
            'messages' => 'Your login information you entered did not matched our records. Please double check and try again'
        ], 401);
    }
}

<?php

namespace App\Modules\Base\Domain;

use App\Modules\Base\Domain\Responder\AuthResponder;
use App\Modules\Common\Domain\Payload;
use Illuminate\Support\{Str, Arr};
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponder
{
    protected $request;
    protected $response;
    protected $payload;
    use AuthResponder;

    public function __invoke(Payload $payload): Response
    {
        $this->payload = $payload;
        $method = $this->getMethodForPayload();
        $this->$method();
        if (app()->environment() == 'production') {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/response.log'),
            ])->info(json_encode($this->response));
        }
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
        $this->response = response()->json([
            'status' => true,
            'messages' => $this->payload->getResult()['messages'] ?? 'Success Deleted'
        ]);
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
                'data'      => $this->payload->getResult()['data']
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

    protected function protectedResource(): void
    {
        $this->response = response()->json([
            'messages' => 'Cant modify this protected Resources'
        ], 403);
    }
    // THROTTLED
    protected function throttled(): void
    {
        $this->response = response()->json([
            'messages' => 'Too many request, please try again later'
        ], 429);
    }

    /*
    * OTHER STATUS
    */

    protected function error(): void
    {
        $this->response = abort(
            response()->json([
                'status' => false,
                'messages' => $this->payload->getResult()['exception']
            ], $this->payload->getResult()['code'])
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
}

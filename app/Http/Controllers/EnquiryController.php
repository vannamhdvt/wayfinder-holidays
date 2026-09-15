<?php

namespace App\Http\Controllers;

use App\Enums\EnquiryStatus;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Resources\EnquiryResource;
use App\Models\TourEnquiry;
use App\Http\Requests\UpdateEnquiryStatusRequest;

class EnquiryController extends Controller
{
    // Staff dashboard: list all enquiries with the tour name
    public function index()
    {
        $enquiries = TourEnquiry::with('tour')->latest()->paginate(25);
        return EnquiryResource::collection($enquiries);
    }
    // Public enquiry form submission
    public function store(StoreEnquiryRequest $request)
    {
        $enquiry = new TourEnquiry($request->validated());
        $enquiry->status = EnquiryStatus::New;
        $enquiry->save();
        return EnquiryResource::make($enquiry->load('tour'))->response()->setStatusCode(201);
    }
    public function updateStatus(UpdateEnquiryStatusRequest $request, TourEnquiry $enquiry)
    {
        $current = $enquiry->status;
        $target = EnquiryStatus::from($request->validated()['status']);

        if (!$current->canTransitionTo($target)) {
            $allowed = array_column($current->allowedTransitions(), 'value');

            return response()->json([
                'message' => sprintf(
                    'Cannot change status from "%s" to "%s".',
                    $current->value,
                    $target->value,
                ),
                'errors' => [
                    'status' => [
                        $allowed === []
                            ? sprintf('"%s" is a final status; no further changes are allowed.', $current->value)
                            : sprintf(
                                'From "%s", the allowed values are: %s.',
                                $current->value,
                                implode(', ', $allowed),
                            ),
                    ],
                ],
            ], 422);
        }

        $enquiry->status = $target;
        $enquiry->save();

        return EnquiryResource::make($enquiry->load('tour'));
    }
}

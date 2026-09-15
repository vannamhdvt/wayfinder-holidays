<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourEnquiry;

class EnquiryController extends Controller
{
    // Staff dashboard: list all enquiries with the tour name
    public function index()
    {
        $enquiries = TourEnquiry::all();
        $result = [];
        foreach ($enquiries as $enquiry) {
            $result[] = [
                'id' => $enquiry->id,
                'name' => $enquiry->name,
                'email' => $enquiry->email,
                'tour_name' => $enquiry->tour->name,
                'status' => $enquiry->status,
            ];
        }
        return response()->json($result);
    }
    // Public enquiry form submission
    public function store(Request $request)
    {
    $enquiry = TourEnquiry::create($request->all());
    return response()->json($enquiry, 201);
    }
}

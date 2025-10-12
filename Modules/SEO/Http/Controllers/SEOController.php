<?php

namespace Modules\SEO\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SEO\Models\Seo;
use Modules\SEO\Http\Requests\SeoRequest;

class SEOController extends Controller
{
    /**
     * Display the SEO settings form.
     */

public function index()
{
    $seo = Seo::first(); // Get the first SEO record

    if(!$seo){
         $seoData = [
            'title' => $seo->meta_title ?? 'Default Title for SEO',
            'description' => $seo->short_description ?? 'Default Description',
            'keywords' => [], // Ensure this is passed as an array
            'author' => $seo->author ?? 'Default Author',
            'seo_image' => $seo->seo_image ?? '',
        ];

        return view('seo::index', compact('seo', 'seoData'));
    }

    // Ensure 'meta_keywords' is an array or a comma-separated string
    $keywords = $seo->meta_keywords ? explode(',', $seo->meta_keywords) : [];

    $seoData = [
        'title' => $seo->meta_title ?? 'Default Title for SEO',
        'description' => $seo->short_description ?? 'Default Description',
        'keywords' => $keywords, // Ensure this is passed as an array
        'author' => $seo->author ?? 'Default Author',
        'seo_image' => $seo->seo_image ?? '',
    ];

    return view('seo::index', compact('seo', 'seoData'));
}

public function store(SeoRequest $request)
{
    $requestData = $request->all();

    // Validate unique meta_title except when updating the same record
    $id = $request->input('id');
    if (Seo::where('meta_title', $requestData['meta_title'])
           ->when($id, fn($q) => $q->where('id', '!=', $id))
           ->exists()) {
        return redirect()->back()
            ->withErrors(['meta_title' => 'This Meta Title is already taken. Please choose a different one.']);
    }

    // Ensure meta_keywords is stored as comma-separated string
    $requestData['meta_keywords'] = isset($requestData['meta_keywords']) && is_array($requestData['meta_keywords'])
        ? implode(',', $requestData['meta_keywords'])
        : '';

    // Handle image upload
    if ($request->hasFile('seo_image')) {
        $image = $request->file('seo_image');
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $image->getClientOriginalName());
        $path = $image->storeAs('public/uploads/seo', $safeName);
        $requestData['seo_image'] = basename($path);
    }

    // Create or update in one line
    Seo::updateOrCreate(
        ['id' => $id],  // match by ID
        $requestData
    );

    return redirect()->back()->with('success', 'SEO settings saved successfully!');
}





public function update(SeoRequest $request, $id)
{
    // Validate the incoming request
    $data = $request->validated();


    // Check if an SEO image is uploaded
    if ($request->hasFile('seo_image')) {
        $image = $request->file('seo_image');

        // Generate a safe filename using a desired pattern or sanitize the original name
        $originalName = $image->getClientOriginalName();
        $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $originalName); // Optional sanitization

        // Store the image in the 'public/uploads/seo' directory
        $path = $image->storeAs('public/uploads/seo', $safeName);

        // Only store the filename in the database, not the full path
        $data['seo_image'] = basename($path);  // Store just the filename
    }

    // Find the SEO record by ID and update it with the new data
    $seo = Seo::findOrFail($id);
    $seo->update($data);


    // Redirect back with a success message
    return redirect()->back()->with('success', 'SEO settings updated successfully!');
}


}

<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;

class UrlFetchingController extends Controller
{
    /**
     * Fetch url meta by specifc url.
     * 
     * @param Request $request
     */
    public function fetchUrlMeta(Request $request) {
        if($request->has('url')) {
            $response = file_get_contents($request->url);
            // $response = get_meta_tags($request->url);
            $title = $description = $image = "";

            $doc = new DOMDocument();
            @$doc->loadHTML($response);

            $nodes = $doc->getElementsByTagName('title');
            $title = $nodes->item(0)->nodeValue;

            $nodes = $doc->getElementsByTagName('meta');
            foreach ($nodes as $node) {
                if($node->getAttribute('name') == 'description') {
                    $description = $node->getAttribute('content');
                    break;
                }
            }

            $nodes = $doc->getElementsByTagName('link');
            foreach ($nodes as $node) {
                if($node->hasAttribute('rel') && $node->getAttribute('rel') == "icon") {
                    $image = $node->getAttribute('href');

                    if(!str_contains("http", $image)) {
                        $image = str_replace('/', '', $image);
                        $prefix = $request->url;
                        $image = $prefix . '/'. $image;
                        $image = filter_var($image, FILTER_SANITIZE_URL);
                    }
                    break;
                }
            }

            return response()->json(['success' => true, 'link' => $request->url, 'meta' => [
                'title' => $title,
                'description' => $description,
                'image' => ['url' => $image],
            ]]);
        }

        return response()->json(['success' => false]);
    }
}
